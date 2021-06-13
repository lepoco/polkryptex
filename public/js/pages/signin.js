import Request from './../components/request.js'
import Toast from './../components/toast.js'

Request.register('#signin', function(status, response){
    console.log(response);
    Toast.send('Error', 'error');
});