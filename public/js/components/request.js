import Toast from "./toast.js?v=1.0.1";
import Translator from "./translator.js?v=1.0.1";

export const name = "Request";

export default class Request {
  static register(form, action) {
    document
      .querySelector(form)
      .addEventListener("submit", (event) =>
        Request.ajax(event, document.querySelector(form), action)
      );
  }

  static ajax(event, form, callAction) {
    event.preventDefault();

    const METHOD = form.method.toUpperCase();
    const XHR = new XMLHttpRequest();

    let endpoint = app.props.ajax;
    let formData = new FormData(form);

    Request.lockForm(form);

    if (METHOD == "GET") {
      endpoint += Request.urlEncode(formData);
    }

    XHR.open(METHOD, endpoint, true);
    XHR.onload = function () {
      Request.unlockForm(form);

      if (app.props.debug) {
        console.log(this.responseText);
      }

      if (Request.isJson(this.responseText)) {
        if (app.props.debug) {
          console.log(JSON.parse(this.responseText));
        }

        let parsedResponse = JSON.parse(this.responseText);

        if (parsedResponse.content.hasOwnProperty("message")) {
          if ("S01" === parsedResponse.status) {
            Toast.send("Cool!", parsedResponse.content.message, "success");
          } else {
            Toast.send("Oh no...", parsedResponse.content.message, "alert");
          }
        }

        //User action
        callAction("OK", JSON.parse(this.responseText));
      } else {
        Toast.send(
          "Error",
          "An error occurred while submitting the form.",
          "alert"
        );
      }
    };

    XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    if (METHOD == "POST") {
      XHR.send(formData);
    } else {
      XHR.send();
    }
  }

  static lockForm(form) {
    Array.prototype.forEach.call(form.elements, (child) => {
      child.disabled = true;
    });
  }

  static unlockForm(form) {
    window.setTimeout(function () {
      Array.prototype.forEach.call(form.elements, (child) => {
        if (child.classList.contains("-keep-disabled")) {
          return;
        }

        child.disabled = false;
      });
    }, 512);
  }

  static urlEncode(fd) {
    var s = "";
    function encode(s) {
      return encodeURIComponent(s).replace(/%20/g, "+");
    }
    for (var pair of fd.entries()) {
      if (typeof pair[1] == "string") {
        s += (s ? "&" : "") + encode(pair[0]) + "=" + encode(pair[1]);
      }
    }
    return "?" + s;
  }

  static isJson(string) {
    if (string == "") {
      return false;
    }
    if (
      /^[\],:{ }\s]*$/.test(
        string
          .replace(/\\["\\\/bfnrtu]/g, "@")
          .replace(
            /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
            "]"
          )
          .replace(/(?:^|:|,)(?:\s*\[)+/g, "")
      )
    ) {
      return true;
    } else {
      return false;
    }
  }
}
