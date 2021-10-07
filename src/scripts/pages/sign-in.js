import Request from "./../common/request";

Request.register("#signin", function (status, response) {
  if (response.status === "S01") {
    window.location.href =
      window.app.props.baseUrl + window.app.props.dashboard;
  }
});
