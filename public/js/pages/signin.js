import Cookies from "js-cookie";
import Request from "./../components/request.js?v=1.0.1";

Request.register("#signin", function (status, response) {
  if (response.status === "S01") {
    Cookies.set("user", response.content.token, {
      expires: 7,
      path: "/",
      secure: app.props.secured,
      sameSite: "Lax",
    });
    window.location.href = app.props.baseUrl + app.props.dashboard;
  }
});
