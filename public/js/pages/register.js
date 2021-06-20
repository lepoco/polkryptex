import Request from "./../components/request.js";
import Toast from "./../components/toast.js";

Request.register("#register", function (status, response) {
  switch (response.status) {
    case "S01":
      window.location.href = app.props.baseUrl + "signin";
      break;

    case "E06":
    case "E07":
      Toast.send("Registration failed", "All fields are required.", "alert");
      break;

    case "E12":
      Toast.send(
        "Registration failed",
        "Provided passwords do not match.",
        "alert"
      );
      break;

    case "E13":
      Toast.send(
        "Registration failed",
        "Provided password is too short.",
        "alert"
      );
      break;

    case "E17":
      Toast.send(
        "Registration failed",
        "The email address provided is already registered.",
        "alert"
      );
      break;

    case "E18":
      Toast.send(
        "Registration failed",
        "You cannot use this username.",
        "alert"
      );
      break;

    default:
      Toast.send(
        "Registration failed",
        "An unknown error has occurred. Please try again later or contact your administrator.",
        "alert"
      );
      break;
  }
});
