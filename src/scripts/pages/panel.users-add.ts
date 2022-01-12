import FormRequest from "../common/formrequest";

/**
 * Page controller for panel.settings.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @module  Pages/Panel/Settings
 * @license GPL-3.0
 * @since   1.1.0
 */
FormRequest.register("#panelAddUser", function (status: string, response: any) {
  if ("S01" === response.status) {
    let fields = document.querySelectorAll("input");
    fields.forEach(function (field: HTMLInputElement) {
      if(field.name === 'nonce' || field.name === 'action' || field.name === 'action') {
        return;
      }

      field.value = "";
    });
  }
});
