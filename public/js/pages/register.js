import Request from "./../components/request.js?v=1.0.1";
import Toast from "./../components/toast.js?v=1.0.1";

Request.register("#register", function (status, response) {
  if ("S01" === response.status) {
    window.location.href = app.props.baseUrl + "signin";
  }
});
