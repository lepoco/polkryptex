import Request from "./../components/request.js?v=1.0.1";
import Toast from "./../components/toast.js?v=1.0.1";

Request.register("#account", function (status, response) {
  if ("S01" === response.status) {
    document.querySelector('input[name="picture"]').value = "";

    const pictureContainer = document.querySelector(
      ".account__banner__picture"
    );
    const pictureImage = document.querySelector(".profile_picture");
    const picturePlaceholder = document.querySelector(".profile_placeholder");

    if (pictureImage && response.content.hasOwnProperty("picture")) {
      pictureImage.src = response.content.picture;
    }

    if (picturePlaceholder && response.content.hasOwnProperty("picture")) {
      picturePlaceholder.remove();

      let picture = document.createElement("img");
      picture.src = response.content.picture;
      pictureContainer.appendChild(picture);
    }
  }
});
