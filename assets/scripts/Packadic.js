/// <reference path="types.d.ts" />
/// <amd-dependency path="bootstrap" />
/// <amd-dependency path="material" />
(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports", "bootstrap", "material", 'jquery', 'eventemitter2', './modules/utilities', './plugins', './layout', './classes/Loader', './modules/debug', './modules/configuration', './modules/promise'], function (require, exports) {
    var $ = require('jquery');
    var EventEmitter2 = require('eventemitter2');
    var util = require('./modules/utilities');
    var plugins_1 = require('./plugins');
    var layout_1 = require('./layout');
    var Loader_1 = require('./classes/Loader');
    var debug_1 = require('./modules/debug');
    var configuration_1 = require('./modules/configuration');
    var promise_1 = require('./modules/promise');
    var $window = $(window), $document = $(document), $body = $(document.body);
    var cre = util.cre, def = util.def, defined = util.defined, trim = util.trim;
    util.addJqueryUtils();
    var Packadic = (function () {
        function Packadic() {
            this.DEBUG = false;
            this.timers = { construct: null, init: null, boot: null };
            this.browser = { ie8: false, ie9: false, ie10: false };
            this.util = util;
            this.events = new EventEmitter2({
                wildcard: true,
                delimiter: ':',
                maxListeners: 1000,
                newListener: true
            });
            $body.data('packadic', this);
            var self = this;
            this.timers.construct = new Date;
            this.initialised = false;
            this.booted = false;
            this.layout = new layout_1.Layout(this);
            this.plugins = new plugins_1.Plugins(this);
            this.browser.ie8 = !!navigator.userAgent.match(/MSIE 8.0/);
            this.browser.ie9 = !!navigator.userAgent.match(/MSIE 9.0/);
            this.browser.ie10 = !!navigator.userAgent.match(/MSIE 10.0/);
            var resize;
            $(window).resize(function () {
                if (resize) {
                    clearTimeout(resize);
                }
                resize = setTimeout(function () {
                    self.emit('resize');
                }, 50);
            });
            this.emit('make');
        }
        Object.defineProperty(Packadic, "instance", {
            get: function () {
                if (typeof Packadic._instance === "undefined") {
                    Packadic._instance = new Packadic();
                }
                return Packadic._instance;
            },
            enumerable: true,
            configurable: true
        });
        Packadic.prototype.init = function (opts) {
            if (opts === void 0) { opts = {}; }
            if (this.initialised) {
                return;
            }
            else {
                this.initialised = true;
            }
            this.timers.init = new Date;
            if (this.DEBUG) {
                debug_1.debug.enable();
                debug_1.debug.setStartDate(this.timers.construct);
            }
            this._config = new configuration_1.ConfigObject($.extend({}, typeof window.packadicConfig == 'object' && window.packadicConfig, opts));
            this.config = configuration_1.ConfigObject.makeProperty(this._config);
            this.emit('init');
            return this;
        };
        Packadic.prototype.boot = function () {
            if (this.booted) {
                return;
            }
            else {
                this.booted = true;
            }
            this.emit('boot');
            this.timers.boot = new Date;
            $('*[data-toggle="popover"]').popover();
            $('*[data-toggle="tooltip"]').tooltip();
            $.material.options = this.config.get('vendor.material');
            $.material.init();
            this.initHighlight();
            this.emit('booted');
            return this;
        };
        Packadic.prototype.el = function (selectorName) {
            var selector = this.config('app.selectors.' + selectorName);
            return $(selector);
        };
        Packadic.prototype.removePageLoader = function () {
            $('body').removeClass('page-loading');
        };
        Packadic.prototype.createLoader = function (name, el) {
            return new Loader_1.Loader(name, el);
        };
        Packadic.prototype.isIE = function (version) {
            if (version === void 0) { version = 0; }
            if (version === 0) {
                if (this.browser.ie8 || this.browser.ie9 || this.browser.ie10) {
                    return true;
                }
            }
            else if (version === 8) {
                return this.browser.ie8;
            }
            else if (version === 9) {
                return this.browser.ie9;
            }
            else if (version === 10) {
                return this.browser.ie10;
            }
            else {
                return false;
            }
        };
        Packadic.prototype.getViewPort = function () {
            return util.getViewPort();
        };
        Packadic.prototype.isTouchDevice = function () {
            return util.isTouchDevice();
        };
        Packadic.prototype.getRandomId = function (length) {
            return util.getRandomId(length);
        };
        Packadic.prototype.getBreakpoint = function (which) {
            return parseInt(this.config.get('app.breakpoints.screen-' + which + '-min').replace('px', ''));
        };
        Packadic.prototype.promise = function () {
            return promise_1.create();
        };
        Packadic.prototype.scrollTo = function (el, offset) {
            var $el = typeof (el) === 'string' ? $(el) : el;
            var pos = ($el && $el.size() > 0) ? $el.offset().top : 0;
            if ($el) {
                if ($body.hasClass('page-header-fixed')) {
                    pos = pos - $('.page-header').height();
                }
                else if ($body.hasClass('page-header-top-fixed')) {
                    pos = pos - $('.page-header-top').height();
                }
                else if ($body.hasClass('page-header-menu-fixed')) {
                    pos = pos - $('.page-header-menu').height();
                }
                pos = pos + (offset ? offset : -1 * $el.height());
            }
            $('html,body').animate({
                scrollTop: pos
            }, 'slow');
        };
        Packadic.prototype.scrollTop = function () {
            this.scrollTo();
        };
        Packadic.prototype.highlight = function (code, lang, wrap, wrapPre) {
            if (wrap === void 0) { wrap = false; }
            if (wrapPre === void 0) { wrapPre = false; }
            var defer = $.Deferred();
            require(['highlightjs', 'css!highlightjs-css/' + this.config('highlightjs.theme')], function (hljs) {
                var highlighted;
                if (lang && hljs.getLanguage(lang)) {
                    highlighted = hljs.highlight(lang, code).value;
                }
                else {
                    highlighted = hljs.highlightAuto(code).value;
                }
                if (wrap) {
                    highlighted = '<code class="hljs">' + highlighted + '</code>';
                }
                if (wrapPre) {
                    highlighted = '<pre>' + highlighted + '</pre>';
                }
                defer.resolve(highlighted);
            });
            return defer.promise();
        };
        Packadic.prototype.initHighlight = function () {
            require(['highlightjs', 'css!highlightjs-css/' + this.config('vendor.highlightjs.theme')], function (hljs) {
                hljs.initHighlighting();
            });
        };
        Packadic.prototype.makeSlimScroll = function (el, opts) {
            if (opts === void 0) { opts = {}; }
            var self = this;
            var $el = typeof (el) === 'string' ? $(el) : el;
            require(['slimscroll'], function () {
                $el.each(function () {
                    if ($(this).attr("data-initialized")) {
                        return;
                    }
                    var height = $(this).attr("data-height") ? $(this).attr("data-height") : $(this).css('height');
                    var data = _.merge(self.config('vendor.slimscroll'), $(this).data(), { height: height });
                    $(this).slimScroll($.extend(true, data, opts));
                    $(this).attr("data-initialized", "1");
                });
            });
        };
        Packadic.prototype.destroySlimScroll = function (el) {
            var $el = typeof (el) === 'string' ? $(el) : el;
            $el.each(function () {
                if ($(this).attr("data-initialized") === "1") {
                    $(this).removeAttr("data-initialized");
                    $(this).removeAttr("style");
                    var attrList = {};
                    if ($(this).attr("data-handle-color")) {
                        attrList["data-handle-color"] = $(this).attr("data-handle-color");
                    }
                    if ($(this).attr("data-wrapper-class")) {
                        attrList["data-wrapper-class"] = $(this).attr("data-wrapper-class");
                    }
                    if ($(this).attr("data-rail-color")) {
                        attrList["data-rail-color"] = $(this).attr("data-rail-color");
                    }
                    if ($(this).attr("data-always-visible")) {
                        attrList["data-always-visible"] = $(this).attr("data-always-visible");
                    }
                    if ($(this).attr("data-rail-visible")) {
                        attrList["data-rail-visible"] = $(this).attr("data-rail-visible");
                    }
                    $(this).slimScroll({
                        wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                        destroy: true
                    });
                    var the = $(this);
                    $.each(attrList, function (key, value) {
                        the.attr(key, value);
                    });
                    $(this).parent().find('> .slimScrollBar, > .slimScrollRail').remove();
                }
            });
        };
        Object.defineProperty(Packadic.prototype, "debug", {
            get: function () {
                return debug_1.debug;
            },
            enumerable: true,
            configurable: true
        });
        Packadic.prototype.on = function (event, listener) {
            this.events.on(event, listener);
            return this;
        };
        Packadic.prototype.once = function (event, listener) {
            this.events.once(event, listener);
            return this;
        };
        Packadic.prototype.off = function (event, listener) {
            this.events.off(event, listener);
            return this;
        };
        Packadic.prototype.emit = function (event) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            if (this.DEBUG) {
                debug_1.debug.logEvent(event, args);
            }
            this.events.emit(event, args);
            return this;
        };
        return Packadic;
    })();
    exports.Packadic = Packadic;
    exports.instance = Packadic.instance;
});
