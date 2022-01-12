import AppData from "./appdata";
import Toast from "./toast";
import Translator from "./translator";

export const name = "FormRequest";

/**
 * Set of tools to facilitate sending Ajax requests for forms.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Common/FormRequest
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class FormRequest {
  static register(form: string, action: CallableFunction) {
    document
      .querySelector(form)
      .addEventListener("submit", (event) =>
      FormRequest.ajax(
          event,
          document.querySelector(form) as HTMLFormElement,
          action
        )
      );
  }

  static ajax(
    event: Event,
    form: HTMLFormElement,
    callAction: CallableFunction
  ) {
    event.preventDefault();

    if (AppData.isDebug()) {
      console.debug("App\\Common\\FormRequest NEW REQUEST", {
        event: event,
        form: form,
        action: callAction
      });
    }

    const METHOD = form.method.toUpperCase();
    const XHR = new XMLHttpRequest();

    let endpoint = AppData.gateway();
    let formData = new FormData(form);

    FormRequest.lockForm(form);
    FormRequest.clearAlertFields(form.elements);

    if (METHOD == "GET") {
      endpoint += FormRequest.urlEncode(formData);
    }

    XHR.open(METHOD, endpoint, true);
    XHR.onload = function () {
      FormRequest.unlockForm(form);

      if (AppData.isDebug()) {
        console.debug("App\\Common\\FormRequest RESPONSE", {
          responseText: this.responseText,
          responseURL: this.responseURL,
          responseType: this.responseType
        });
      }

      if (FormRequest.isJson(this.responseText)) {
        let parsedResponse = JSON.parse(this.responseText);

        if (AppData.isDebug()) {
          console.debug("App\\Common\\FormRequest JSON", parsedResponse);
        }

        if (parsedResponse.content.hasOwnProperty("redirect")) {
          window.location.href = parsedResponse.content.redirect;

          return;
        }

        if (parsedResponse.content.hasOwnProperty("message")) {
          if ("S01" === parsedResponse.status) {
            Toast.send("Cool!", parsedResponse.content.message, "success");
          } else {
            Toast.send("Oh no...", parsedResponse.content.message, "alert");
          }
        }

        if (parsedResponse.content.hasOwnProperty("fields")) {
          FormRequest.alertFields(parsedResponse.content.fields);
        }

        if (parsedResponse.content.hasOwnProperty("update")) {
          FormRequest.updateFields(parsedResponse.content.update);
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

  static lockForm(form: HTMLFormElement) {
    Array.prototype.forEach.call(form.elements, (child: HTMLFormElement) => {
      child.disabled = true;
    });
  }

  static unlockForm(form: HTMLFormElement) {
    window.setTimeout(function () {
      Array.prototype.forEach.call(form.elements, (child: HTMLFormElement) => {
        if (child.classList.contains("-keep-disabled")) {
          return;
        }

        child.disabled = false;
      });
    }, 512);
  }

  static alertFields(fields: any) {
    Array.prototype.forEach.call(fields, (child: any) => {
      let field = document.querySelector('input[name="' + child + '"]');

      if (field) {
        field.classList.add("-alert");
      }
    });
  }

  static clearAlertFields(fields: any) {
    Array.prototype.forEach.call(fields, (child: any) => {
      child.classList.remove("-alert");
    });
  }

  static updateFields(fields: any) {
    Array.prototype.forEach.call(fields, (child: any) => {
      const element = document.querySelector(child.selector);

      switch (child.type) {
        case "value":
          element.value = child.value;
          break;

        case "text":
          element.textContent = child.value;
          break;

        case "src":
          element.src = child.value;
          break;
      }
    });
  }

  static urlEncode(formData: any) {
    let s = "";
    function encode(s: any) {
      return encodeURIComponent(s).replace(/%20/g, "+");
    }
    for (let pair of formData.entries()) {
      if (typeof pair[1] == "string") {
        s += (s ? "&" : "") + encode(pair[0]) + "=" + encode(pair[1]);
      }
    }
    return "?" + s;
  }

  static isJson(string: String) {
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
