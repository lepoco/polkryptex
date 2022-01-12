import FormRequest from "../common/formrequest";
import Ajax from "../common/ajax";
import UserCard from "../common/usercard";

/**
 * Page controller for dashboard.payments.send.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Pages/Dashboard/PaymentsSend
 * @license GPL-3.0
 * @since   1.1.0
 */

const INPUT_AMOUNT = document.querySelector('input[name="amount"]');
const PAYEE_FIELD = document.querySelector('input[name="payee"]');
const PAYEE_NAME_FIELD = document.querySelector('input[name="payee_name"]');
const PAYEE_CONTAINER = document.querySelector(".payee-container");

const INPUT_WAIT = 1000;
let GLOBAL_THREAD = 0;

FormRequest.register("#paymentsSend", function (status: string, response: any) {
  if ("S01" === response.status) {
    if (INPUT_AMOUNT instanceof HTMLInputElement) {
      INPUT_AMOUNT.value = "";
    }

    if (PAYEE_FIELD instanceof HTMLInputElement) {
      PAYEE_FIELD.value = "";
    }

    if (PAYEE_NAME_FIELD instanceof HTMLInputElement) {
      PAYEE_NAME_FIELD.value = "";
    }

    PAYEE_CONTAINER.innerHTML = "";
  }
});

async function findUser(control: HTMLInputElement, dataset: DOMStringMap) {
  control.disabled = true;

  let formData = {
    nonce: dataset["nonce"] ?? "",
    action: dataset["action"] ?? "",
    id: dataset["id"] ?? "",
    phrase: control.value,
  };

  Ajax.call(formData, (status: string, responseData: any) => {
    if (
      !responseData.hasOwnProperty("content") ||
      !responseData.content.hasOwnProperty("user_name")
    ) {
      control.disabled = false;

      return;
    }

    PAYEE_CONTAINER.innerHTML = "";

    if (PAYEE_CONTAINER) {
      UserCard.append(
        PAYEE_CONTAINER,
        responseData["content"]["user_name"],
        responseData["content"]["user_display_name"],
        responseData["content"]["user_image"],
        function () {
          if (PAYEE_FIELD instanceof HTMLInputElement) {
            PAYEE_FIELD.disabled = false;
          }
          if (PAYEE_NAME_FIELD instanceof HTMLInputElement) {
            PAYEE_NAME_FIELD.value = "";
          }
        }
      );
    }

    if (PAYEE_NAME_FIELD instanceof HTMLInputElement) {
      PAYEE_NAME_FIELD.value = responseData["content"]["user_name"];
    }

    console.debug(status);
    console.debug(responseData);
  });
}

function onPayeeChanged(event: Event, control: HTMLInputElement) {
  const THREAD_ID = Math.floor(Math.random() * 99999 + 1);
  GLOBAL_THREAD = THREAD_ID;

  setTimeout(() => {
    if (GLOBAL_THREAD !== THREAD_ID) {
      return;
    }

    findUser(control, control.dataset);
  }, INPUT_WAIT);
}

if (PAYEE_FIELD instanceof HTMLInputElement) {
  PAYEE_FIELD.addEventListener("input", (e) => onPayeeChanged(e, PAYEE_FIELD));
}
