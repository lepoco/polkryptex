import {Toast} from './bootstrap-core.js'

//https://getbootstrap.com/docs/5.0/getting-started/javascript/
export const name = 'BootstrapJS';

export default class BootstrapJS {

    constructor(ctx) {
        this.registerToast();
    }

    registerToast() {
        Array.from(document.querySelectorAll('.toast')).forEach(toastNode => new Toast(toastNode))
    }
}