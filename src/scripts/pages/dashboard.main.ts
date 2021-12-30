/**
 * Page controller for dashboard.main.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Pages/Dashboard/Main
 * @license GPL-3.0
 * @since   1.1.0
 */

function walletChanged(event: Event, select: HTMLSelectElement) {
  const walletValue = document.querySelector(".wallet-current-value");

  if (!walletValue) {
    return;
  }

  let valueToPrint = "";
  let selectedOption = select.options[select.selectedIndex];

  if (selectedOption.dataset["signleft"] == "1") {
    valueToPrint += selectedOption.dataset["sign"] + " ";
  }

  valueToPrint += selectedOption.value;

  if (selectedOption.dataset["signleft"] == "0") {
    valueToPrint += " " + selectedOption.dataset["sign"];
  }

  walletValue.innerHTML = valueToPrint;
}

const walletSelector = document.querySelector('select[name="select-wallet"]');

if (walletSelector && walletSelector instanceof HTMLSelectElement) {
  walletSelector.addEventListener("change", (e) =>
    walletChanged(e, walletSelector)
  );
}
