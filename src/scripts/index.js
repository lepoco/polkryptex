/**
 * Polkryptex
 * https://polkryptex.pl/
 * 
 * GPL-3.0 https://github.com/Polkryptex/Polkryptex/blob/main/LICENSE
 */
 if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("service-worker.js")
      .then((registration) => {
        console.log("SW registered: ", registration);
      })
      .catch((registrationError) => {
        console.log("SW registration failed: ", registrationError);
      });
  });
}

require("./common/footer");
require("./common/cookie");
require("./common/signout");

import("./../sass/style.scss");

try {
  require("./pages/" + window.app.props.view);
  window.app.routing = { success: true, message: "imported" };
} catch (error) {
  window.app.routing = {
    success: false,
    message: "No module for page " + window.app.props.view,
    error: error.message
  };
}


console.log(window.app);