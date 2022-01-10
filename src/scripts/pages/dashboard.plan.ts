import FormRequest from "../common/formrequest";

/**
 * Page controller for dashboard.plan.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Pages/Dashboard/Plan
 * @license GPL-3.0
 * @since   1.1.0
 */
FormRequest.register(
  "#selectPlan",
  function (status: string, response: any) {}
);

const FEE_BOX = document.querySelector('.monthly-fee');
const RADIO_PLANS = document.querySelectorAll('input[name="plan_tier"]');

function radioOnClick(event: MouseEvent, element: HTMLInputElement) {
  console.debug(event);
  console.debug(element);
  console.debug(element.dataset);

  FEE_BOX.innerHTML = '$ ' + element.dataset['price'];
}

function registerRadioButton(element: Element) {
  if (element instanceof HTMLInputElement) {
    element.addEventListener("click", (e) => radioOnClick(e, element));
  }
}

if (RADIO_PLANS) {
  RADIO_PLANS.forEach((e) => registerRadioButton(e));
}
