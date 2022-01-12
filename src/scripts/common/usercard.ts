import AppData from "./appdata";

export const name = "UserCard";

/**
 * Executes an asynchronous query.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Common/UserCard
 * @license GPL-3.0
 * @since   1.1.0
 */
export default class UserCard {
  static append(
    element: any,
    name: string,
    displayName: string,
    image: string = "",
    onClose: CallableFunction
  ) {
    let userCardElement = UserCard.build(name, displayName, image, onClose);

    if (element instanceof HTMLElement) {
      element.appendChild(userCardElement);
    }
  }

  private static build(
    name: string,
    displayName: string,
    image: string = "",
    onClose: CallableFunction
  ): HTMLDivElement {
    const CONTAINER = document.createElement("div");
    const PROFILE_ELEMENT = document.createElement("div");
    const PROFILE_IMAGE = document.createElement("img");
    const NAME_CONTAINER = document.createElement("div");
    const NAME_PARAGRAPH = document.createElement("p");
    const DISPLAY_NAME_SPAN = document.createElement("span");
    const CLOSE_ELEMENT = document.createElement("div");
    CLOSE_ELEMENT.classList.add("close");

    CONTAINER.classList.add("user-card");
    CONTAINER.id = "user-card-" + name.trim();

    PROFILE_ELEMENT.classList.add("profile");

    let profileImage = image.trim();
    if (profileImage == "" || profileImage == undefined) {
      profileImage = AppData.url("img/pexels-watch-pay.jpeg?v=1.1.0");
    }

    if (AppData.isDebug()) {
      console.debug("\\Common\\UserCard User image", profileImage);
      console.debug("\\Common\\UserCard User name", name);
      console.debug("\\Common\\UserCard User display name", displayName);
    }

    PROFILE_IMAGE.src = profileImage;

    NAME_PARAGRAPH.classList.add("-font-secondary");
    NAME_PARAGRAPH.classList.add("-fw-700");
    NAME_PARAGRAPH.innerHTML = displayName;

    DISPLAY_NAME_SPAN.innerHTML = '&#64;' + name;

    NAME_CONTAINER.appendChild(NAME_PARAGRAPH);
    NAME_CONTAINER.appendChild(DISPLAY_NAME_SPAN);

    PROFILE_ELEMENT.appendChild(PROFILE_IMAGE);
    PROFILE_ELEMENT.appendChild(NAME_CONTAINER);

    const CLOSE_IMAGE = document.createElement("img");
    CLOSE_IMAGE.src = AppData.url("img/svg/close.svg?v=1.1.0");
    CLOSE_ELEMENT.appendChild(CLOSE_IMAGE);

    CLOSE_ELEMENT.addEventListener("click", (e) =>
      UserCard.onCloseClick(e, CONTAINER, onClose)
    );

    CONTAINER.appendChild(PROFILE_ELEMENT);
    CONTAINER.appendChild(CLOSE_ELEMENT);

    return CONTAINER;
  }

  private static onCloseClick(
    e: Event,
    element: HTMLDivElement,
    onClose: CallableFunction
  ): void {
    element.remove();

    onClose();
  }
}
