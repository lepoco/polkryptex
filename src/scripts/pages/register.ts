import AppData from "./../common/appdata";
import Request from "./../common/request";
import Toast from "./../common/toast";

/**
 * Page controller for register.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Common/AppData
 * @license GPL-3.0
 * @since   1.1.0
 */
Request.register("#register", function (status: string, response: any) {
  if ("S01" === response.status) {
    window.location.href = AppData.url("signin");
  }
});
