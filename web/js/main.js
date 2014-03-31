require.config({
    paths: {
        'jquery': 'lib/jquery-2.1.0.min',
        'underscore': 'lib/underscore-min',
        'backbone': 'lib/backbone-min',
        'backbone-paginator': 'lib/backbone.paginator',
        'bootstrap': 'lib/bootstrap.min',
        'bootstrap-datepicker': 'lib/bootstrap-datepicker',
        // Models
        // Collections
        // Views

    },
    shim: {
        'underscore': {
            deps: [],
            exports: '_'
        },
        'backbone': {
            deps: ['jquery', 'underscore'],
            exports: 'Backbone'
        },
        'backbone-paginator': {
            deps: ['underscore', 'jquery', 'backbone'],
            exports: 'Backbone.Paginator'
        },
        'bootstrap': {
            deps: ['jquery'],
            exports: 'Bootstrap'
        },
        'bootstrap-datepicker': {
            deps: ['jquery', 'bootstrap'],
            exports: 'Datepicker'
        }
    }
});

require(['jquery', 'bootstrap'],
    function($) {
        $(function() {

        });
    }
);