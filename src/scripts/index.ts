/**
 * Index
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Index
 * @license GPL-3.0
 * @since   1.1.0
 */

import AppData from "./common/appdata";
import FormHelpers from "./common/formhelpers";
import Cookie from "./common/cookie";
import SignOut from "./common/signout";
import LoadReveal from "./common/loadreveal";
import CreditCard from "./common/creditcard";

import { Dropdown as BootstrapDropdown } from "./components/bootstrap-bundle";

require("./../sass/style.scss");

window.onload = function (e) {
  FormHelpers.init();
  Cookie.init();
  SignOut.init();
  CreditCard.init();

  let drop = new BootstrapDropdown();
};

if (AppData.isWorkerEnabled() && "serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register(AppData.url("service-worker.js"))
      .then((registration) => {
        if (AppData.isDebug()) {
          console.debug("App\\Index SW REGISTERED", registration);
        }

        //registration.pushManager.subscribe({userVisibleOnly: true, applicationServerKey: "71562645621"});
      })
      .catch((registrationError) => {
        if (AppData.isDebug()) {
          console.debug("App\\Index SW REGISTRATION FAILED", registrationError);
        }
      });
  });
}

window.onload = function (e) {
  try {
    require("./pages/" + AppData.pageNow());
    AppData.setRouting({ success: true, message: "imported" });

    LoadReveal.init();
  } catch (error) {
    AppData.setRouting({
      success: false,
      message: "No module for page " + AppData.pageNow(),
      error: error.message,
    });

    LoadReveal.init();
  }
};

function navigatorOnline() {
  if (!window.navigator.onLine) {
    document.body.classList.add("--offline");
  } else if (document.body.classList.contains("--offline")) {
    console.log("Connection established!");
    window.location.href = window.location.href;

    return;
  }

  setTimeout(navigatorOnline, 2500);
}
navigatorOnline();

if (AppData.isDebug()) {
  AppData.dump();
}
