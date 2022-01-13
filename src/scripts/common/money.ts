export const name = "Money";

/**
 * Performs operations on currencies.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Common/Money
 * @license GPL-3.0
 * @since   1.2.0
 */
export default class Money {
  static format(amount: number): string {
    let formatted = amount.toFixed(10);

    formatted = Money.trim(formatted, "0");

    if (formatted.endsWith(".") || formatted.endsWith(",")) {
      formatted += "00";
    }

    if (formatted.startsWith(".") || formatted.startsWith(",")) {
      formatted = "0" + formatted;
    }

    return formatted;
  }

  static trim(s: string, c: string): string {
    if (c === "]") c = "\\]";
    if (c === "^") c = "\\^";
    if (c === "\\") c = "\\\\";

    return s.replace(new RegExp("^[" + c + "]+|[" + c + "]+$", "g"), "");
  }
}
