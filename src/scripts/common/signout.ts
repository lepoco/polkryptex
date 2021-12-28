import AppData from "./appdata";

export const name = "SignOut";

/**
 * Displays information about the ending time of the session.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Common/SignOut
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class SignOut {
  timeout: number = 0;

  static init() {
    return new SignOut();
  }

  constructor() {
    if (AppData.isDebug()) {
      console.debug("App\\Common\\SignOut REGISTERED", AppData.isLogged());
    }

    if (!AppData.isLogged()) {
      return;
    }

    this.setTimeout();
    this.startTimer();
  }

  setTimeout() {
    let timeout = AppData.signoutTime();

    if (timeout < 3) {
      this.timeout = 3;
    }

    this.timeout = timeout;
  }

  startTimer() {
    let absoluteTimeout = (this.timeout - 2) * 60 * 1000;

    if (AppData.isDebug()) {
      console.debug("App\\Common\\SignOut TIMEOUT STARTED", absoluteTimeout);
    }

    window.setTimeout(function () {
      SignOut.showWidget();
    }, absoluteTimeout);
  }

  static showWidget() {
    const modalElement = document.querySelector(".signout");

    if (AppData.isDebug()) {
      console.debug("App\\Common\\SignOut TIME PASSED; MINUTE LEFT");
    }

    if (modalElement) {
      modalElement.classList.add("--show");

      SignOut.startCountdown();
    }
  }

  static startCountdown() {
    const TIMER_ELEMENT = document.querySelector(".signout__modal--timer");

    let count = 59,
      timer = setInterval(function () {
      
        TIMER_ELEMENT.innerHTML = "00:" + (count < 10 ? '0' + count : count);

        count--;

        if (count == 0) {
          clearInterval(timer);
          window.location.href = AppData.url("signout");
        }
      }, 1000);
  }
}
