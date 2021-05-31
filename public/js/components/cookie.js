import { jQuery }  from 'jquery'
window.jQuery = jQuery;

export const name = 'Cookie';

export default class Cookie {

  constructor(ctx) {
    console.log(jQuery);

    let x = jQuery('.abc');
    console.log(x); 
    
    
  }

}