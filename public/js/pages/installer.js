import Request from "./../components/request.js?v=1.0.1";
import Toast from "./../components/toast.js?v=1.0.1";

Request.register("#install", function (status, response) {
  console.log(response);

  switch (response.status) {
    case "S01":
      Toast.send(
        "It worked!",
        "The application has been successfully installed. The page will be refreshed in a moment...",
        "success"
      );
      window.setTimeout(function () {
        window.location.href = app.props.baseUrl;
      }, 500);
      break;

    case "E07":
      Toast.send("Damn it!", "All fields must be completed", "alert");
      break;
    default:
      Toast.send(
        "Damn it!",
        "Installation failed for an unknown reason",
        "alert"
      );
      break;
  }
});
