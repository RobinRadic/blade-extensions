var packadicConfig = (function () {
    var bowerDir = '../bower_components/';
    var requireJs = {
        baseUrl: "assets/scripts/",
        paths: {
            'eventemitter2': bowerDir + 'eventemitter2/lib/eventemitter2',
            'async': bowerDir + 'async/dist/async.min',
            'jade': bowerDir + 'jade/runtime',
            'jquery': 'jquery-custom.min',
            'bootstrap': bowerDir + 'bootstrap/dist/js/bootstrap.min',
            'material': bowerDir + 'bootstrap-material-design/dist/js/material.min',
            'ripples': bowerDir + 'bootstrap-material-design/dist/js/ripples.min',
            'svg': bowerDir + 'svg.js/dist/svg',
            'backbone': bowerDir + 'backbone/backbone-min',
            'lunr': bowerDir + 'lunr.js/lunr.min',
            'fuse': bowerDir + 'fuse/src/fuse.min',
            'slimscroll': bowerDir + 'jquery-slimscroll/jquery.slimscroll.min',
            'highlightjs': bowerDir + 'highlightjs/highlight.pack',
            'jstree': bowerDir + 'jstree/dist/jstree.min',
            'x-editable': bowerDir + 'x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min',
            'colorpicker': bowerDir + 'mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min',
            'spectrum': bowerDir + 'spectrum/spectrum',
            'bootstrap-switch': bowerDir + 'bootstrap-switch/dist/js/bootstrap-switch.min',
            'highlightjs-css': bowerDir + 'highlightjs/styles',
            'jstree-css': bowerDir + 'jstree/dist/themes/default/style.min'
        },
        map: {
            '*': {
                'css': bowerDir + 'require-css/css.min'
            }
        },
        shim: {
            'svg': { exports: 'SVG' },
            'app': ['jquery', 'bootstrap', 'material'],
            'jade': { exports: 'jade' },
            'lunr': { exports: 'lunr' },
            'fuse': { exports: 'Fuse' },
            'jquery': {
                exports: '$', init: function () {
                    this.jquery.noConflict();
                }
            },
            'highlightjs': { exports: 'hljs' },
            'material': ['jquery', 'bootstrap'],
            'ripples': ['jquery', 'material'],
            'bootstrap': ['jquery'],
            'slimscroll': ['jquery'],
            'jstree': ['jquery'],
            'x-editable': ['jquery', 'bootstrap'],
            'spectrum': ['jquery'],
            'bootstrap-switch': ['jquery', 'bootstrap'],
            'typedoc': ['backbone', 'lunr'],
            'sassdoc/main': ['jquery', 'Packadic', 'fuse'],
            'sassdoc/search': ['sassdoc/main'],
            'sassdoc/sidebar': ['sassdoc/search']
        },
        waitSeconds: 5,
        config: {
            debug: true
        }
    };
    return {
        paths: {
            assets: 'assets'
        },
        requirejs: requireJs,
        app: {
            name: 'DocGen',
            plugins: ['example', 'styler', 'customizer'],
            selectors: {
                'search': '.sidebar-search',
                'header': '.page-header',
                'header-inner': '<%= selectors.header %> .page-header-inner',
                'container': '.page-container',
                'sidebar-wrapper': '.page-sidebar-wrapper',
                'sidebar': '.page-sidebar',
                'sidebar-menu': '.page-sidebar-menu',
                'content-wrapper': '.page-content-wrapper',
                'content': '.page-content',
                'content-head': '<%= selectors.content %> .page-head',
                'content-breadcrumbs': '<%= selectors.content %> .page-breadcrumbs',
                'content-inner': '<%= selectors.content %> .page-content-inner',
                'footer': '.page-footer',
                'footer-inner': '.page-footer-inner',
            },
            breakpoints: {
                'screen-lg-med': "1260px",
                'screen-lg-min': "1200px",
                'screen-md-max': "1199px",
                'screen-md-min': "992px",
                'screen-sm-max': "991px",
                'screen-sm-min': "768px",
                'screen-xs-max': "767px",
                'screen-xs-min': "480px"
            },
            sidebar: {
                autoScroll: true,
                keepExpanded: true,
                slideSpeed: 200,
                togglerSelector: '.sidebar-toggler',
                openCloseDuration: 600,
                openedWidth: 235,
                closedWidth: 54,
                resolveActive: true
            },
            preferences: {
                sidebar: {
                    hidden: false,
                    closed: false,
                    reversed: false,
                    fixed: true,
                    compact: false,
                },
                header: {
                    fixed: true
                },
                footer: {
                    fixed: true
                },
                page: {
                    boxed: false
                }
            },
            customizer: {
                definitions: [
                    { name: '', title: 'Layout', type: 'header' },
                    { name: 'header.fixed', title: 'Header fixed', type: 'boolean' },
                    { name: 'footer.fixed', title: 'Footer fixed', type: 'boolean' },
                    { name: 'page.boxed', title: 'Page boxed', type: 'boolean' },
                    { name: '', title: 'Sidebar', type: 'header' },
                    { name: 'sidebar.hidden', title: 'Hidden', type: 'boolean' },
                    { name: 'sidebar.closed', title: 'Closed', type: 'boolean' },
                    { name: 'sidebar.resolveActive', title: 'Autoresolve active', type: 'boolean' },
                    { name: 'sidebar.reversed', title: 'Switch sides', type: 'boolean' },
                    { name: 'sidebar.compact', title: 'Compact', type: 'boolean' },
                    { name: 'sidebar.fixed', title: 'Fixed', type: 'boolean' },
                ]
            }
        },
        vendor: {
            material: {
                input: true,
                ripples: false,
                checkbox: true,
                togglebutton: true,
                radio: true,
                arrive: true,
                autofill: false,
                withRipples: [
                    ".btn:not(.btn-link)",
                    ".card-image",
                    ".navbar a:not(.withoutripple)",
                    ".dropdown-menu a",
                    ".nav-tabs a:not(.withoutripple)",
                    ".withripple"
                ].join(","),
                inputElements: "input.form-control, textarea.form-control, select.form-control",
                checkboxElements: ".checkbox > label > input[type=checkbox]",
                togglebuttonElements: ".togglebutton > label > input[type=checkbox]",
                radioElements: ".radio > label > input[type=radio]"
            },
            slimscroll: {
                allowPageScroll: false,
                size: '6px',
                color: '#000',
                wrapperClass: 'slimScrollDiv',
                railColor: '#222',
                position: 'right',
                height: '200px',
                alwaysVisible: false,
                railVisible: true,
                disableFadeOut: true
            },
            highlightjs: {
                theme: 'tomorrow'
            }
        }
    };
}.call(this));
