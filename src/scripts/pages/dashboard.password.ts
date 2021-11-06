import FormRequest from "../common/formrequest";

/**
 * Page controller for dashboard.password.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @module  Pages/Dashboard/Password
 * @license GPL-3.0
 * @since   1.1.0
 */
FormRequest.register("#changePassword", function (status: string, response: any) {
  if ("S01" === response.status) {
    let fields = document.querySelectorAll('input[type="password"]');
    fields.forEach(function (field: HTMLFormElement) {
      field.value = "";
    });
  }
});
