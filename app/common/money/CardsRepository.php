<?php

namespace App\Common\Money;

use App\Core\Facades\{DB, Cache};
use App\Core\Auth\User;
use App\Core\Data\Encryption;
use App\Common\Money\Card;

use function Safe\base64_decode;

/**
 * Contains the logic responsible for managing the credit cards.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class CardRepository
{
  public static function getUserCards(User $user): array
  {
    $userCards = [];

    // $dbCards = Cache::remember('user_cards.'.$user-id(), 3600, fn() => {
    // });

    $dbCards = DB::table('user_cards')->where(['user_id' => $user->id()])->get()->all();

    foreach ($dbCards as $singleCardObject) {
      if (!isset($singleCardObject->id) || !isset($singleCardObject->user_id) || !isset($singleCardObject->key_id)) {
        continue;
      }

      $decryptedCard = self::decryptCardObject($singleCardObject);

      if (!empty($decryptedCard)) {
        $userCards[] = $decryptedCard;
      }
    }

    return $userCards;
  }

  public static function cardExists(User $user, Card $card): bool
  {
    if (!$card->isValid()) {
      return false;
    }

    $userCards = self::getUserCards($user);

    foreach ($userCards as $userCard) {
      if ($userCard->number == $card->number) {
        return true;
      }
    }

    return false;
  }

  public static function addUserCard(User $user, Card $card): array
  {
    if ($user->id() < 1 || !$card->isValid()) {
      return [];
    }

    if (self::cardExists($user, $card)) {
      return [];
    }

    $cardId = Encryption::salter(16, 'N');
    $cardVector = Encryption::generateVector();

    $encryptedNumber = Encryption::encrypt($card->number, $cardVector);
    $encryptedHolder = Encryption::encrypt($card->holder, $cardVector);
    $encryptedExpiration = Encryption::encrypt(json_encode($card->expiration), $cardVector);
    $encryptedSecurity = Encryption::encrypt($card->security, $cardVector);

    $cardKeyName = 'user_card:' . $cardId;

    $vectorId = self::saveVector($user->id(), $cardKeyName, base64_encode($cardVector));

    if ($vectorId < 1) {
      return [];
    }

    $savedCard = self::saveCard(
      $user->id(),
      $vectorId,
      $encryptedNumber,
      $encryptedHolder,
      $encryptedExpiration,
      $encryptedSecurity
    );

    return [
      'card_id' => $savedCard,
      'key_id' => $vectorId,
      'card_name' => $cardKeyName
    ];
  }

  private static function saveVector(int $userId, string $name, string $vector): int
  {
    return DB::table('user_keys')->insertGetId([
      'user_id' => $userId,
      'name' => $name,
      'key' => $vector,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ]);
  }

  private static function getVector(int $vectorId): string
  {
    $query = DB::table('user_keys')->where(['id' => $vectorId])->get('*')->first();

    if (!isset($query->id)) {
      return '';
    }

    return $query->key ?? '';
  }

  private static function saveCard(int $userId, int $keyId, string $number, string $holder, string $expiration, string $security): int
  {
    return DB::table('user_cards')->insertGetId([
      'key_id' => $keyId,
      'user_id' => $userId,
      'number' => $number,
      'holder' => $holder,
      'expiration' => $expiration,
      'security' => $security,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ]);
  }

  private static function decryptCardObject(object $cardObject): ?Card
  {
    if (!isset($cardObject->key_id)) {
      return null;
    }

    $key = self::getVector($cardObject->key_id);

    if (empty($key)) {
      return null;
    }

    $decryptedKey = base64_decode($key);
    $decryptedCard = new Card();

    if (empty($decryptedKey)) {
      return null;
    }

    $decryptedCard->number = Encryption::decrypt($cardObject->number ?? '', $decryptedKey);
    $decryptedCard->holder = Encryption::decrypt($cardObject->holder ?? '', $decryptedKey);
    $decryptedCard->security = (int)Encryption::decrypt($cardObject->security ?? '', $decryptedKey);
    $decryptedCard->expiration = json_decode(Encryption::decrypt($cardObject->expiration ?? '', $decryptedKey) ?? '[]', true);

    return $decryptedCard;
  }
}
