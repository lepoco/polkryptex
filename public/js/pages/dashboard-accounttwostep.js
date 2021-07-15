// import * as useRegistration from "./../webauth/useRegistration.js?v=0.0.13";

// //console.log(useRegistration.default);

// let testRegistrationRequest = useRegistration.default(app.props.baseUrl + 'request', {}, app.props.baseUrl + 'request', {});
// let res = testRegistrationRequest();

// console.log(res);
import WebAuth from "./../components/webauth.js?v=1.0.0";

let wa = new WebAuth();

let reg = wa.useRegistration('/');

console.log(wa);
console.log(reg);