import FormRequest from "../common/formrequest";

/**
 * Page controller for dashboard.exchange.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Pages/Dashboard/Exchange
 * @license GPL-3.0
 * @since   1.1.0
 */

const INPUT_FROM = document.querySelector('select[name="wallet_from"]');
const INPUT_TO = document.querySelector('select[name="wallet_to"]');
const INPUT_AMOUNT = document.querySelector('input[name="amount"]');

const RATE_BOX = document.querySelector('.exchange-rate');
const AMOUNT_BOX = document.querySelector('.exchanged-amount');

FormRequest.register("#exchange", function (status: string, response: any) {
  if ("S01" === response.status) {
  }
});

function getRate() : number {
  if(!(INPUT_FROM instanceof HTMLSelectElement && INPUT_TO instanceof HTMLSelectElement)) {
    return;
  }

  let walletFrom = INPUT_FROM.options[INPUT_FROM.selectedIndex];
  let walletTo = INPUT_TO.options[INPUT_TO.selectedIndex];

  let fromRate = parseFloat(walletFrom.dataset['rate'] ?? '1');
  let toRate = parseFloat(walletTo.dataset['rate'] ?? '1');

  let isCrypto = (walletFrom.dataset['crypto'] ?? '0') == '1' || (walletTo.dataset['crypto'] ?? '0') == '1';

  return (1 / fromRate ) * toRate;
}

function isAnyCrypto() : boolean {
  if(!(INPUT_FROM instanceof HTMLSelectElement && INPUT_TO instanceof HTMLSelectElement)) {
    return;
  }

  let walletFrom = INPUT_FROM.options[INPUT_FROM.selectedIndex];
  let walletTo = INPUT_TO.options[INPUT_TO.selectedIndex];

  return (walletFrom.dataset['crypto'] ?? '0') == '1' || (walletTo.dataset['crypto'] ?? '0') == '1';
}

function updateRate() : void {
  if(!(INPUT_FROM instanceof HTMLSelectElement && INPUT_TO instanceof HTMLSelectElement)) {
    return;
  }

  let walletTo = INPUT_TO.options[INPUT_TO.selectedIndex];

  let isCrypto = isAnyCrypto();
  let rate = getRate();

  if (RATE_BOX instanceof HTMLHeadingElement) {
    //RATE_BOX.innerHTML = Intl.NumberFormat('en-US').format(rate);
    RATE_BOX.innerHTML = (isCrypto ? rate.toFixed(8) : rate.toFixed(4)) + ' ' + walletTo.value ?? '';
  }
}

function lockOptions() : void {
  if(!(INPUT_FROM instanceof HTMLSelectElement && INPUT_TO instanceof HTMLSelectElement)) {
    return;
  }

  let walletFrom = INPUT_FROM.options[INPUT_FROM.selectedIndex];
  let walletTo = INPUT_TO.options[INPUT_TO.selectedIndex];

  if(INPUT_FROM.selectedIndex == INPUT_TO.selectedIndex) {
    INPUT_TO.selectedIndex = INPUT_TO.selectedIndex == 0 ? 1 : 0;
  }

  let activeCurrency = walletFrom.value ?? '';

  Array.from(INPUT_TO.options).forEach(function(singleOption) {
    singleOption.disabled = activeCurrency == singleOption.value;
    singleOption.hidden = activeCurrency == singleOption.value;
});
}

function updateAmount() {
  if (!(INPUT_AMOUNT instanceof HTMLInputElement)) {
    return;
  }

  if(!(INPUT_FROM instanceof HTMLSelectElement && INPUT_TO instanceof HTMLSelectElement)) {
    return;
  }

  let walletTo = INPUT_TO.options[INPUT_TO.selectedIndex];

  let rate = getRate();
  let amount = parseFloat(INPUT_AMOUNT.value);
  let isCrypto = isAnyCrypto();

  if (AMOUNT_BOX instanceof HTMLHeadingElement) {
    if(INPUT_AMOUNT.value == '') {
      AMOUNT_BOX.innerHTML = '0';
    } else {
      AMOUNT_BOX.innerHTML = (isCrypto ? (amount * rate).toFixed(6) : (amount * rate).toFixed(2)) + ' ' + walletTo.value ?? '';
    }
  }
}

function selectionChanged(event:Event) {
  lockOptions();
  updateRate();
  updateAmount();
}

function amountChanged(event:Event, input:HTMLInputElement) {
  input.value = Math.abs(parseFloat(input.value)).toString();
  updateAmount();
}

lockOptions();
updateRate();

if (INPUT_FROM instanceof HTMLSelectElement) {
  INPUT_FROM.addEventListener("change", (e) => selectionChanged(e));
}

if (INPUT_TO instanceof HTMLSelectElement) {
  INPUT_TO.addEventListener("change", (e) => selectionChanged(e));
}

if (INPUT_AMOUNT instanceof HTMLInputElement) {
  INPUT_AMOUNT.addEventListener("input", (e) => amountChanged(e, INPUT_AMOUNT));
}