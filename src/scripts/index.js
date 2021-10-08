/**
 * Polkryptex
 * https://polkryptex.pl/
 *
 * GPL-3.0 https://github.com/Polkryptex/Polkryptex/blob/main/LICENSE
 */

import Cookie from "./common/cookie";
import SignOut from "./common/signout";

if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("https://polkryptex.lan/service-worker.js")
      .then((registration) => {
        if (window.app.props.debug) {
          console.log("SW registered: ", registration);
        }

        //registration.pushManager.subscribe({userVisibleOnly: true, applicationServerKey: "71562645621"});
      })
      .catch((registrationError) => {
        if (window.app.props.debug) {
          console.log("SW registration failed: ", registrationError);
        }
      });
  });
}

new Cookie();
new SignOut();


require("./common/notifications");

import("./../sass/style.scss");

try {
  require("./pages/" + window.app.props.view);
  window.app.routing = { success: true, message: "imported" };
} catch (error) {
  window.app.routing = {
    success: false,
    message: "No module for page " + window.app.props.view,
    error: error.message,
  };
}

if (!window.navigator.onLine) {
  document.body.classList.add("--offline");
}

if (window.app.props.debug) {
  console.debug("window.app", window.app);
  console.debug("Connection online", window.navigator.onLine);
}
