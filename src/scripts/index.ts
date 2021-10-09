/**
 * Polkryptex
 * https://polkryptex.pl/
 *
 * GPL-3.0 https://github.com/Polkryptex/Polkryptex/blob/main/LICENSE
 */

import Cookie from "./common/cookie";
import SignOut from "./common/signout";

let appData = (window as any).app;

require("./../sass/style.scss");

if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("https://polkryptex.lan/service-worker.js")
      .then((registration) => {
        if (appData.props.debug) {
          console.log("SW registered: ", registration);
        }

        //registration.pushManager.subscribe({userVisibleOnly: true, applicationServerKey: "71562645621"});
      })
      .catch((registrationError) => {
        if (appData.props.debug) {
          console.log("SW registration failed: ", registrationError);
        }
      });
  });
}

new Cookie();
new SignOut();

try {
  require("./pages/" + appData.props.view);
  appData.routing = { success: true, message: "imported" };
} catch (error) {
  appData.routing = {
    success: false,
    message: "No module for page " + appData.props.view,
    error: error.message,
  };
}

if (!window.navigator.onLine) {
  document.body.classList.add("--offline");
}

if (appData.props.debug) {
  console.debug("window.app", appData);
  console.debug("Connection online", window.navigator.onLine);
}
