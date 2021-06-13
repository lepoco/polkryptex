import Toast from './toast.js'

export const name = 'Request';

export default class Request {

    static register(form, action) {
        document.querySelector(form).addEventListener('submit', event => Request.ajax(event, document.querySelector(form), action));
    }

    static ajax(event, form, callAction) {
        event.preventDefault();

        const ENDPOINT = app.props.ajax;
        let data = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', ENDPOINT, true);
        xhr.onload = function () {
            if (Request.isJson(this.responseText)) {
                //Action
                callAction('OK', this.responseText);
            }
            else {
                Toast.send('Error', 'An error occurred while submitting the form.', 'alert');
            }
        };
        xhr.send(data);
    }

    static isJson(string) {
        if (string == '') { return false; }
        if (/^[\],:{ }\s]*$/.test(string.replace(/\\["\\\/bfnrtu]/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) { return true; } else { return false; }
    }
}