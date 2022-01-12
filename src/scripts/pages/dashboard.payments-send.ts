import FormRequest from "../common/formrequest";
import Ajax from "../common/ajax"

/**
 * Page controller for dashboard.payments.send.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Pages/Dashboard/PaymentsSend
 * @license GPL-3.0
 * @since   1.1.0
 */
FormRequest.register(
  "#paymentsSend",
  function (status: string, response: any) {}
);

const INPUT_WAIT = 1000;
let GLOBAL_THREAD = 0;

async function findUser(control:HTMLInputElement, dataset:DOMStringMap) {
  control.disabled = true;

  let formData = {
    nonce: dataset['nonce'] ?? '',
    action: dataset['action'] ?? '',
    id: dataset['id'] ?? '',
    phrase: control.value
  };

  Ajax.call(formData, (status:string, responseData: any) => {
    control.disabled = false;

    console.debug(status);
    console.debug(responseData);
  });
}

function onPayeeChanged(event: Event, control:HTMLInputElement) {
  const THREAD_ID = Math.floor((Math.random() * 99999) + 1);
  GLOBAL_THREAD = THREAD_ID;

  setTimeout(() => {
    if(GLOBAL_THREAD !== THREAD_ID) {
      return;
    }

    findUser(control, control.dataset)
  }, INPUT_WAIT);
}

const PAYEE_FIELD = document.querySelector('input[name="payee"]');

if (PAYEE_FIELD instanceof HTMLInputElement) {
  PAYEE_FIELD.addEventListener("input", (e) => onPayeeChanged(e, PAYEE_FIELD));
}
