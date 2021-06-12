import Request from './../components/request.js'

Request.register('#install', function(status, response){
    console.log('CALL SUCCESS');
    console.log(response);
});