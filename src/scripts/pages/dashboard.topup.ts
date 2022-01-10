import FormRequest from "../common/formrequest";

/**
 * Page controller for dashboard.topup.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Pages/Dashboard/Topup
 * @license GPL-3.0
 * @since   1.1.0
 */
FormRequest.register("#topup", function (status: string, response: any) {
  if ("S01" === response.status) {
  }
});
