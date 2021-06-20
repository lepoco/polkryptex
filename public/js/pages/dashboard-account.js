import Request from "./../components/request.js";
import Toast from "./../components/toast.js";

Request.register("#account", function (status, response) {
  if (response.status === "S01") {
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
