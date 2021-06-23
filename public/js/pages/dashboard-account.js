import Request from "./../components/request.js";
import Toast from "./../components/toast.js";

Request.register("#account", function (status, response) {
  if (response.status === "S01") {

    document.querySelector('input[name="picture"]').value = "";

    const pictureContainer = document.querySelector('.account__banner__picture');
    const pictureImage  = document.querySelector('.profile_picture');
    const picturePlaceholder = document.querySelector('.profile_placeholder');

    if(pictureImage && response.content.hasOwnProperty('picture')) {
      pictureImage.src = response.content.picture;
    }
    
    if(picturePlaceholder && response.content.hasOwnProperty('picture')) {
      picturePlaceholder.remove();

      let picture = document.createElement("img");
      picture.src = response.content.picture;
      pictureContainer.appendChild(picture);
    }

    Toast.send(
      "Cool!",
      "Your profile information has been updated.",
      "success"
    );
  } else {
    Toast.send(
      "Oh no...",
      "An error has occurred, the profile could not be updated.",
      "alert"
    );
  }
});
