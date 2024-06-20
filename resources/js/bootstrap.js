window._ = require('lodash');
import * as Bootstrap from 'bootstrap';
import Chart from 'chart.js/auto';
import jQuery from 'jquery';

import jszip from 'jszip';
import pdfmake from 'pdfmake';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-buttons';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-buttons/js/buttons.html5.mjs';


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
try {
    window.Popper = require('@popperjs/core').default;
    window.Bootstrap = Bootstrap;
    window.Swal = require('sweetalert2');
    window.topbar = require('topbar');
    require('./main');
    window.Chart = Chart;
    window.$ = window.jQuery = jQuery;
    window.DataTable = DataTable;
    window.pdfmake = pdfmake;
    window.jszip = jszip;
    require('select2');
} catch (e) {}
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';






/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
