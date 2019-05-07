const $ = require('jquery')
import 'bootstrap'
import '../sass/admin.sass'
import 'startbootstrap-sb-admin-2/js/sb-admin-2.min'
import 'bootstrap-select'
const _ = require('underscore')
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
// require('../css/app.css');


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');
global.$ = global.jQuery = $;
global._ = _;

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
