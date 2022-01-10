import AppData from "./appdata";
import { Toast as BootstrapToast } from "./../components/bootstrap-bundle";

export const name = "Toast";

/**
 * Adds a new notification to the displayed pool.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Common/Toast
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class Toast {
  static send(header:string, message:string = null, type = "default", timeout = 5000) {
    const CONTAINER = document.querySelector(".toast__container");
    const TOAST_ID = "toast-" + parseInt((Math.random() * 1000000000).toString(), 10);
    const TIME_NOW = new Date(
      Date.now() - new Date().getTimezoneOffset() * 60000
    ).toISOString().substr(11, 8);

    AppData.addToast(header, message, Date.now());

    let icon = null;
    switch (type) {
      case "success":
        icon =
          '<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" /><path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z" />';
        break;
      case "alert":
        icon =
          '<path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z" /><path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z" />';
        break;
      default:
        icon =
          '<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" /><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />';
        break;
    }

    let toastElement = document.createElement("div");
    toastElement.id = TOAST_ID;
    toastElement.classList.add("toast");
    //toastElement.classList.add('fade');
    toastElement.classList.add("hide");
    toastElement.innerHTML =
      '<div class="toast-header"><svg fill="currentColor" width="20" height="20" xmlns="http://www.w3.org/2000/svg" focusable="false">' +
      icon +
      '</svg><strong class="me-auto">' +
      header +
      "</strong><small>" +
      TIME_NOW +
      '</small></div><div class="toast-body">' +
      message +
      "</div>";

    CONTAINER.appendChild(toastElement);

    let toast = new BootstrapToast(document.getElementById(TOAST_ID), {
      animate: true,
      delay: timeout,
    });
    toast.show();
  }
}
