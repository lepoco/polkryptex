<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

use \Jenssegers\Blade\Blade;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * TODO This class is a huge mess
 * 
 * @author Leszek P.
 */
final class Mailer
{
  protected const MAILS_PATH = 'views/mails/';

  protected const CACHE_PATH = 'cache/';

  private \Jenssegers\Blade\Blade $blade;

  private PHPMailer $mail;

  private array $viewData = [];
  
  private array $sections = [];

  public function __construct()
  {
    $this->mail = new PHPMailer(true);
    $this->mail->SMTPDebug = Debug::isMailDebug();

    $this->setupSMTP();
    $this->setupMailer();
  }

  /**
   * @param Array|String $recipient
   * */
  public function send($recipients, ?string $subject = null, ?string $header = null, ?string $message = null, ?string $altMessage = null, string $template = 'default'): bool
  {
    try {

      if (is_array($recipients)) {
        foreach ($recipients as $recipient) {
          $this->mail->addAddress($recipient);
        }
      }

      if (!is_array($recipients)) {
        $this->mail->addAddress($recipients);
        //$this->mail->addAddress('joe@example.net', 'Joe User');
      }

      $this->addData('subject', $subject);
      $this->addData('header', $header);
      $this->addData('message', $message);

      $this->mail->isHTML(true);
      $this->mail->Subject = $subject ?? Application::getOption('site_name', 'Polkryptex');


      $this->mail->Body = $this->fromTemplate($template);
      $this->mail->AltBody = null === $altMessage ? $this->plainBody($message) : $altMessage;

      if (!Debug::isDebug()) {
        $this->mail->XMailer = 'Microsoft Mailer';
      }

      $this->mail->send();

      return true;
    } catch (Exception $e) {
      //echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
      return false;
    }
  }

  public function addData(string $key, $data): void
  {
    $this->viewData[$key] = $data;
  }

  public function addSection(array $args): void
  {
    $this->sections[] = $args;
  }

  public function addAttachment(string $filePath, string $fileName = ''): void
  {
    $this->mail->addAttachment($filePath, $fileName);
  }

  public function addCC(string $mail): void
  {
    $this->mail->addCC($mail);
  }

  public function addBCC(string $mail): void
  {
    $this->mail->addBCC($mail);
  }

  private function fromTemplate(string $template): string
  {
    $this->blade = new \Jenssegers\Blade\Blade(ABSPATH . APPDIR . self::MAILS_PATH, ABSPATH . APPDIR . self::CACHE_PATH);
    $this->blade->directive('option', function ($name, $default = null) {
      return '<?php echo \App\Core\Application::getOption(' . $name . ', ' . $default . '); ?>';
    });

    $this->viewData['sections'] = $this->sections;

    if (!$this->blade->exists($template)) {
      $template = 'default';
    }

    return $this->blade->render($template, $this->viewData);
  }

  private function setupMailer(): void
  {
    $this->mail->setFrom(
      Application::getOption('mail_sendfrom', 'mail@example.com'), //sender address
      Application::getOption('mail_sendname', 'Polkryptex') //sender name
    );

    $this->mail->addReplyTo(
      Application::getOption('mail_replyto', 'mail@example.com'), //sender name
      Application::getOption('mail_sendname', 'Polkryptex') //sender addres   
    );

    $this->mail->CharSet = 'UTF-8';
    //Content-Type: text/plain; charset="UTF-8"; format=flowed; delsp=yes

    $baseurl = Application::getOption('baseurl', 'https://example.com/');

    $this->template = 'main';
    $this->logo = Application::getOption('mail_logo', $baseurl . 'media/icons/192.png');
    $this->url = Application::getOption('baseurl', $baseurl);
    $this->title = Application::getOption('mail_title', 'Polkryptex INC');
    $this->footer = Application::getOption('mail_footer', 'Polkryptex INC, NY Box 1002/1');
    $this->subfooter = 'You received this email to let you know about important changes to your Polkryptex Account and services.';
    //<a class="original-only" style="color: #666666; text-decoration: none;">Unsubscribe</a><span class="original-only" style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span><a style="color: #666666; text-decoration: none;">View this email in your browser</a>
  }

  private function setupSMTP(): void
  {
    if (!Application::getOption('mail_smtp', false)) {
      return;
    }

    $this->mail->isSMTP();                                            //Send using SMTP
    $this->mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $this->mail->Username   = 'user@example.com';                     //SMTP username
    $this->mail->Password   = 'secret';                               //SMTP password
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  }

  private function plainBody(?string $message = null): string
  {
    $plainMessage = '';

    if (!empty($message)) {
      $plainMessage .= $message . PHP_EOL . PHP_EOL;
    }

    foreach ($this->sections as $section) {
      if (isset($section['header'])) {
        $plainMessage .= str_replace('<br>', PHP_EOL, $section['header']) . PHP_EOL;
      }

      if (isset($section['message'])) {
        $plainMessage .= str_replace('<br>', PHP_EOL, $section['message']) . PHP_EOL;
      }

      $plainMessage .= PHP_EOL;

      if (isset($section['buttons']) && is_array($section['buttons'])) {
        foreach ($section['buttons'] as $button) {
          if (isset($button['url'])) {
            $plainMessage .= $button['url'] . PHP_EOL;
          }
        }
      }
    }

    return $plainMessage;
  }
}
