import { Toast } from './components/bootstrap.js'
import Cookie from './components/cookie.js'

new Cookie();
Array.from(document.querySelectorAll('.toast')).forEach(toastNode => new Toast(toastNode))