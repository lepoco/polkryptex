import Request from './../components/request.js'
import Toast from './../components/toast.js'

Request.register('#signin', function(status, response){
    console.log(response);

    if (response.status !== 'S01')
    {
        Toast.send('Login failed', 'The provided username or password is incorrect', 'alert');
    }
});