export const name = 'Request';

export default class Request {

    static register(form, action) {
        document.querySelector(form).addEventListener('submit', event => Request.ajax(event, document.querySelector(form), action));
    }

    static ajax(event, form, callAction)
    {
        event.preventDefault();

        const ENDPOINT = app.props.ajax;

        let data = new FormData(form);
        // data.append('user', 'person');
        // data.append('pwd', 'password');
        // data.append('organization', 'place');
        // data.append('requiredkey', 'key');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', ENDPOINT, true);
        xhr.onload = function () {
            // do something to response
            callAction('OK', this.responseText);
        };
        xhr.send(data);

        // var xmlhttp = new XMLHttpRequest();

        // xmlhttp.onreadystatechange = function () {
        //     if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
        //         callAction('OK', xmlhttp.responseText);
        //         // if (xmlhttp.status == 200) {
        //         //     document.getElementById("myDiv").innerHTML = ;
        //         // }
        //         // else if (xmlhttp.status == 400) {
        //         //     alert('There was an error 400');
        //         // }
        //         // else {
        //         //     alert('something else other than 200 was returned');
        //         // }
        //     }
        // };

        // xmlhttp.open('POST', ENDPOINT, true);
        //xmlhttp.send();
    }
}