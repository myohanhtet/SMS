
window._ = global._ = require('lodash');
let d3 = require("d3");

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
window.$ = window.jQuery = global.jQuery = global.$ = require('jquery');
try {

    require('jquery-ui');
    require('jquery-ui-sortable');

    require('./tooltip-conflict');

    require('bootstrap-sass');

    /**
     * Vue is a modern JavaScript library for building interactive web interfaces
     * using reactive data binding and reusable components. Vue's API is clean
     * and simple, leaving you to focus on building your next great project.
     */



    /**
     * Require datatables library
     */
    require('datatables.net');
    require('datatables.net-bs');

    require('datatables.net-buttons');

    require('gasparesganga-jquery-loading-overlay');
    //require( './plugins/buttons.server-side');
    // require('./buttons.server-side-post');
    require('datatables.net-buttons-bs');
    require( 'datatables.net-buttons/js/buttons.colVis' );
    require( 'datatables.net-responsive' );



    window.moment = global.moment = require('moment');



    require('select2');
    require('select2/dist/js/i18n/en');

    require('admin-lte');

    global.hyperform = window.hyperform = require('hyperform');

    require('jquery-datetimepicker');

    require('formBuilder');
    require('formBuilder/dist/form-render.min');


} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
