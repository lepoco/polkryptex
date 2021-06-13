import Request from './../components/request.js'
import Toast from './../components/toast.js'

Request.register('#install', function(status, response){
    switch (response.status) {
        case 'S01':
            Toast.send('It worked!', 'The application has been successfully installed. The page will be refreshed in a moment...', 'success');

            window.setTimeout(function () {
                window.location.href = app.props.baseUrl;
            }, 4000);
            break;

        case 'E07':
            Toast.send('Damn it!', 'All fields must be completed', 'alert');
            console.log(response);
            break;
    
        default:
            Toast.send('Damn it!', 'Installation failed for an unknown reason', 'alert');
            console.log(response);
            break;
    }
});