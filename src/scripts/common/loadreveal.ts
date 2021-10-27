import AppData from "./appdata";
import * as ScrollReveal from "./../components/scrollreveal";

export const name = "LoadReveal";

/**
 * Animates pages when opened.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Common/AppData
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class LoadReveal {
  constructor() {
    ScrollReveal().reveal(".-reveal", {
      //delay: 150,
      duration: 500,
      interval: 16,
      reset: false,
      scale: .9,
      cleanup: false,
      origin: 'bottom',
      easing: 'cubic-bezier(0.5, 0, 0, 1)'
    });
  }
}
