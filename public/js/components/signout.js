import * as Bootstrap from "./bootstrap-core.js";

export const name = "SignOut";

export default class SignOut {
  constructor(ctx) {
    if (!app.auth.loggedIn) {
      return;
    }

    this.setTimeout();
    this.startTimer();
  }

  setTimeout() {
    let timeout = parseInt(app.props.loginTimeout);

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
          window.location.href = app.props.baseUrl + "signout";
        }
      }, 1000);
  }
}
