import Request from "./../components/request.js";
import Toast from "./../components/toast.js";

Request.register("#register", function (status, response) {
  if ("S01" === response.status) {
    window.location.href = app.props.baseUrl + "signin";
  }
});
