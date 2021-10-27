import AppData from "./appdata";
import * as Bootstrap from "./../components/bootstrap-bundle";

export const name = "SignOut";

/**
 * Displays information about the ending time of the session.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Common/AppData
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class SignOut {
  timeout: number;

  static init() {
    return new SignOut();
  }

  constructor() {
    if (!AppData.isLogged()) {
      return;
    }

    this.setTimeout();
    this.startTimer();
  }

  setTimeout() {
    let timeout = AppData.signoutTime();

    if (timeout < 1) {
      this.timeout = 10;
    }

    this.timeout = timeout;
  }

  startTimer() {
    window.setTimeout(function () {
      SignOut.showWidget();
    }, (this.timeout - 1) * 60 * 1000);
  }

  static showWidget() {
    const modalElement = document.getElementById("signout__modal-modal");
    console.log("The session expires. You will be logged out in a minute.");

    if (modalElement) {
      let modal = new Bootstrap.Modal(modalElement, {
        backdrop: "static",
        keyboard: false,
        focus: true,
      });

      modal.show();
      SignOut.startCountdown();

      document
        .querySelector(".signout__modal-button")
        .addEventListener("click", function () {
          location.reload();
        });
    }
  }

  static startCountdown() {
    const TIMER_ELEMENT = document.querySelector(".signout__modal-timer");

    let count = 59,
      timer = setInterval(function () {
        TIMER_ELEMENT.innerHTML = "00:" + count--;

        if (count == 0) {
          clearInterval(timer);
          window.location.href = AppData.url("signout");
        }
      }, 1000);
  }
}
