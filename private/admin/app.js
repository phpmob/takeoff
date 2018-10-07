// to share jquery for all `webpack.config.addEntry(...)`
window.$ = window.jQuery = require('jquery');

require('jquery-confirm');
require('bootstrap');

require('chang/js/data-confirm');
require('chang/js/data-ajax-form');
require('chang/js/form-collection');
require('chang/js/form-validator-html5');
require('chang/js/data-toggle-display');
require('chang/js/data-form-filter');

require('ui/modern/js/animated');
require('ui/modern/js/crud');
require('ui/modern/js/menu/stack');
require('ui/modern/js/modal-close');
require('ui/modern/js/modal-href');
require('ui/modern/js/dismiss');
require('ui/modern/js/tabs');
require('ui/modern/js/toggle');
require('ui/modern/js/tooltip');
require('ui/modern/js/ripple');
require('ui/modern/js/navbar');
