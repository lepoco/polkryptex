import AppData from "./appdata";

export const name = "Ajax";

/**
 * Executes an asynchronous query.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Common/Ajax
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class Ajax {
  static async call(data: any, callAction: CallableFunction) {
    if (AppData.isDebug()) {
      console.debug("App\\Common\\Ajax NEW REQUEST", {
        action: data['action'],
      });
    }

    const METHOD = "GET";
    const XHR = new XMLHttpRequest();

    let endpoint = AppData.gateway();
    endpoint += Ajax.urlEncode(data);

    XHR.open(METHOD, endpoint, true);

    XHR.onload = function () {
      if (AppData.isDebug()) {
        console.debug("App\\Common\\Ajax RESPONSE", {
          responseText: this.responseText,
          responseURL: this.responseURL,
          responseType: this.responseType
        });
      }

      if (Ajax.isJson(this.responseText)) {
        let parsedResponse = JSON.parse(this.responseText);

        if (AppData.isDebug()) {
          console.debug("App\\Common\\Ajax JSON", parsedResponse);
        }

        //User action
        callAction("OK", JSON.parse(this.responseText));
      } else {
        callAction("FAIL", JSON.parse(this.responseText));
      }
    };

    XHR.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    XHR.send();
  }

  static sleep(ms: number) {
    return new Promise((resolve) => setTimeout(resolve, ms));
  }

  static urlEncode(formData: any) {
    let s = "";

    function encode(s: any) {
      return encodeURIComponent(s).replace(/%20/g, "+");
    }

    for (let pair of Object.entries(formData)) {
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
