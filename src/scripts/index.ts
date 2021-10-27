/**
 * Polkryptex
 * https://polkryptex.pl/
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Common/AppData
 * @license GPL-3.0
 * @since   1.1.0
 */

import AppData from "./common/appdata";
import FormHelpers from "./common/formhelpers";
import Cookie from "./common/cookie";
import SignOut from "./common/signout";

require("./../sass/style.scss");

if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register(AppData.url("service-worker.js"))
      .then((registration) => {
        if (AppData.isDebug()) {
          console.log("SW registered: ", registration);
        }

        //registration.pushManager.subscribe({userVisibleOnly: true, applicationServerKey: "71562645621"});
      })
      .catch((registrationError) => {
        if (AppData.isDebug()) {
          console.log("SW registration failed: ", registrationError);
        }
      });
  });
}

new FormHelpers();
new Cookie();
new SignOut();

try {
  require("./pages/" + AppData.pageNow());
  AppData.setRouting({ success: true, message: "imported" });
} catch (error) {
  AppData.setRouting({
    success: false,
    message: "No module for page " + AppData.pageNow(),
    error: error.message,
  });
}

if (!window.navigator.onLine) {
  document.body.classList.add("--offline");
}

if (AppData.isDebug()) {
  AppData.dump();
}
