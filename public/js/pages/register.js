import Request from "./../components/request.js";
import Toast from "./../components/toast.js";

Request.register("#register", function (status, response) {
  if (response.status === "S01") {
    //window.location.href = app.props.baseUrl + app.props.dashboard;
  } else {
    Toast.send(
      "Login failed",
      "The provided username or password is incorrect.",
      "alert"
    );
  }
});
