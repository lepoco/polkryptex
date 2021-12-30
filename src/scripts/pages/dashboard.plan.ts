import FormRequest from "../common/formrequest";

/**
 * Page controller for dashboard.plan.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Pages/Dashboard/Plan
 * @license GPL-3.0
 * @since   1.1.0
 */
FormRequest.register(
  "#selectPlan",
  function (status: string, response: any) {}
);

function buttonNextClick(event: MouseEvent) {
  const SECTION_SELECT = document.querySelector("#plan-select");
  const SECTION_CARD = document.querySelector("#plan-card");

  SECTION_SELECT.classList.add("-hidden");
  SECTION_CARD.classList.remove("-hidden");

  console.debug(event);
}

function buttonFinishClick(event: MouseEvent) {
  const SECTION_CARD = document.querySelector("#plan-card");
  const SECTION_FINISH = document.querySelector("#plan-finish");

  SECTION_CARD.classList.add("-hidden");
  SECTION_FINISH.classList.remove("-hidden");

  console.debug(event);
}

const BUTTON_NEXT_CARD = document.querySelector(".btn-plan-next-card");
const BUTTON_NEXT_FINISH = document.querySelector(".btn-plan-next-finish");

if (BUTTON_NEXT_CARD && BUTTON_NEXT_CARD instanceof HTMLButtonElement) {
  BUTTON_NEXT_CARD.addEventListener("click", (e) => buttonNextClick(e));
}

if (BUTTON_NEXT_FINISH && BUTTON_NEXT_FINISH instanceof HTMLButtonElement) {
  BUTTON_NEXT_FINISH.addEventListener("click", (e) => buttonFinishClick(e));
}
