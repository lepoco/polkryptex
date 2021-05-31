import Cookie from './components/cookie.js'
import Router from './components/router.js'

import { Toast } from './components/bootstrap.js'

new Cookie();
new Router();

//https://getbootstrap.com/docs/5.0/getting-started/javascript/
Array.from(document.querySelectorAll('.toast')).forEach(toastNode => new Toast(toastNode))