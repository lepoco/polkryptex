import Request from "./../common/request"
import Toast from "./../common/toast"

Request.register("#register", function (status, response) {
  if ("S01" === response.status) {
    window.location.href = window.app.props.baseUrl + "signin";
  }
});
