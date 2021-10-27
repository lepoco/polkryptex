import AppData from "./../common/appdata";
import Request from "./../common/request";

/**
 * Page controller for sign-in.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Common/AppData
 * @license GPL-3.0
 * @since   1.1.0
 */
Request.register("#signin", function (status: string, response: any) {
  if (response.status === "S01") {
    window.location.href = (window as any).app.props.baseUrl + AppData.url();
  }
});
