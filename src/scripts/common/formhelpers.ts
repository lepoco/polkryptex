export const name = "FormHelpers";

/**
 * Triggers a set of automatic functions to facilitate the use of forms.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Common/FormHelpers
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class FormHelpers {
  static init() {
    return new FormHelpers();
  }

  constructor() {
    this.fillSelected();
    this.searchableSelects();
  }

  fillSelected() {
    const SELECTS = document.querySelectorAll("select");

    if (!SELECTS) {
      return;
    }

    Array.prototype.forEach.call(SELECTS, (child: HTMLSelectElement) => {
      const DATASET = child.dataset;

      if (!DATASET.hasOwnProperty("selected")) {
        return;
      }

      const SELECTED_VALUE = DATASET.selected;

      Array.prototype.forEach.call(
        child.options,
        (option: HTMLOptionElement) => {
          if (SELECTED_VALUE == option.value) {
            option.selected = true;
          }
        }
      );
    });
  }

  searchableSelects() {
    const SELECTS = document.querySelectorAll(".floating-search");

    if (!SELECTS) {
      return;
    }

    Array.prototype.forEach.call(SELECTS, (child: HTMLDivElement) => {
      FormHelpers.makeSelectSearchable(child);
    });
  }

  // It's just an idea to polish

  static makeSelectSearchable(parentElement: HTMLDivElement) {
    let contentElement = document.createElement("div");
    contentElement.classList.add("floating-search__content");

    contentElement.addEventListener("click", (e) =>
      FormHelpers.searchableSelectClick(e, parentElement)
    );

    let searchListElement = document.createElement("li");
    searchListElement.classList.add("--input");
    let searchInputElement = document.createElement("input");

    searchInputElement.addEventListener('keypress', e => FormHelpers.searchableInputKeyPress(e, parentElement))

    if (parentElement.dataset["placeholder"] != undefined) {
      searchInputElement.placeholder = parentElement.dataset["placeholder"];
    } else {
      searchInputElement.placeholder = "Search...";
    }

    let selectableList = document.createElement("ul");
    selectableList.classList.add("floating-search__selectors");

    searchListElement.appendChild(searchInputElement);
    selectableList.appendChild(searchListElement);

    parentElement.childNodes.forEach((childNode) => {
      if (childNode instanceof HTMLSelectElement) {
        for (let index = 0; index < childNode.options.length; index++) {
          if (childNode.options[index].disabled) {
            continue;
          }

          let listElement = document.createElement("li");

          listElement.innerHTML = childNode.options[index].innerText;
          listElement.dataset["value"] = childNode.options[index].value;

          listElement.addEventListener("click", (e) =>
            FormHelpers.searchableListClick(e, parentElement)
          );

          selectableList.appendChild(listElement);
        }

        return;
      }
    });

    parentElement.appendChild(contentElement);
    parentElement.appendChild(selectableList);

    console.debug(selectableList);
  }

  static searchableSelectClick(event: MouseEvent, element: HTMLDivElement) {
    if (element.classList.contains("--opened")) {
      element.classList.remove("--opened");
    } else {
      element.classList.add("--opened");
    }

    console.debug(event);
  }

  static searchableListClick(event: MouseEvent, parentElement: HTMLDivElement) {
    if (!(event.target instanceof HTMLLIElement)) {
      return;
    }

    if (event.target.dataset["value"] == undefined) {
      return;
    }

    let content = event.target.innerText;
    let value = event.target.dataset["value"];

    parentElement.childNodes.forEach((childNode) => {
      if (childNode instanceof HTMLSelectElement) {
        for (let index = 0; index < childNode.options.length; index++) {
          if (childNode.options[index].value == value) {
            childNode.options[index].selected = true;
          } else {
            childNode.options[index].selected = false;
          }
        }
      }

      if (childNode instanceof HTMLDivElement) {
        childNode.innerHTML = content;
      }
    });

    if (parentElement.classList.contains("--opened")) {
      parentElement.classList.remove("--opened");
    }

    parentElement.classList.add("--selected");
  }

  static searchableInputKeyPress(event:KeyboardEvent, parentElement: HTMLDivElement) {
    console.debug(event);
    console.debug(event.target);
  }
}
