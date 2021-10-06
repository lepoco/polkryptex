import Cookies from "./../components/js.cookie"
import Request from "./../common/request"

Request.register("#signin", function (status, response) {
  if (response.status === "S01") {
    Cookies.set("user", response.content.token, {
      expires: 7,
      path: "/",
      secure: window.app.props.secured,
      sameSite: "Lax",
    });
    window.location.href = window.app.props.baseUrl + window.app.props.dashboard;
  }
});
