import Cookies from "js-cookie";
import Request from "./../components/request.js?v=1.0.1";

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
