var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports", 'jquery', './BaseApp', './modules/utilities', './modules/debug'], function (require, exports) {
    /// <reference path="types.d.ts" />
    var $ = require('jquery');
    var BaseApp_1 = require('./BaseApp');
    var utilities_1 = require('./modules/utilities');
    var debug_1 = require('./modules/debug');
    var Plugins = (function (_super) {
        __extends(Plugins, _super);
        function Plugins() {
            _super.apply(this, arguments);
            this.namespacePrefix = 'packadic.';
            this._plugins = {};
            this.defaultRegOpts = {
                loadPath: 'app/plugins/',
                callback: $.noop()
            };
        }
        Plugins.prototype.boot = function () {
            var self = this;
            var plugins = this.config('app.plugins');
        };
        Plugins.prototype._add = function (name, PluginClass, regOpts) {
            if (this.has(name)) {
                throw new Error('Plugin already registered');
            }
            regOpts = $.extend(true, this.defaultRegOpts, { 'class': PluginClass }, regOpts);
            if (utilities_1.kindOf(regOpts.namespace) !== 'string') {
                regOpts.namespace = name;
            }
            regOpts.namespace = this.namespacePrefix + regOpts.namespace;
            return this._plugins[name] = regOpts;
        };
        Plugins.prototype.register = function (name, PluginClass, regOpts) {
            regOpts = this._add(name, PluginClass, regOpts);
            var packadic = this.p;
            function jQueryPlugin(options) {
                var args = [];
                for (var _i = 1; _i < arguments.length; _i++) {
                    args[_i - 1] = arguments[_i];
                }
                var all = this.each(function () {
                    var $this = $(this);
                    var data = $this.data(regOpts.namespace);
                    var opts = $.extend({}, PluginClass.defaults, $this.data(), typeof options == 'object' && options);
                    if (!data) {
                        $this.data(regOpts.namespace, (data = new PluginClass(packadic, this, opts, regOpts.namespace)));
                    }
                    if (utilities_1.kindOf(options) === 'string') {
                        data[options].call(data, args);
                    }
                    if (utilities_1.kindOf(regOpts.callback) === 'function') {
                        regOpts.callback.apply(this, [data, opts]);
                    }
                });
                if (utilities_1.kindOf(options) === 'string' && options === 'instance' && all.length > 0) {
                    if (all.length === 1) {
                        return $(all[0]).data(regOpts.namespace);
                    }
                    else {
                        var instances = [];
                        all.each(function () {
                            instances.push($(this).data(regOpts.namespace));
                        });
                        return instances;
                    }
                }
                return all;
            }
            var old = $.fn[name];
            $.fn[name] = jQueryPlugin;
            $.fn[name].Constructor = PluginClass;
        };
        Plugins.prototype.load = function (name, cb, loadPath) {
            if (loadPath === void 0) { loadPath = 'plugins/'; }
            var self = this;
            if (utilities_1.kindOf(name) === 'array') {
                return name.forEach(function (n) {
                    self.load(n, cb, loadPath);
                });
            }
            if (this.has(name)) {
                loadPath = this.get(name).loadPath;
            }
            require([loadPath + name], function () {
                if (utilities_1.kindOf(cb) === 'function') {
                    cb.apply(this, arguments);
                }
            });
        };
        Plugins.prototype.has = function (name) {
            return utilities_1.kindOf(name) === 'string' && Object.keys(this._plugins).indexOf(name) !== -1;
        };
        Plugins.prototype.get = function (name) {
            return utilities_1.defined(name) ? this._plugins[name] : this._plugins;
        };
        return Plugins;
    })(BaseApp_1.BaseApp);
    exports.Plugins = Plugins;
    function register(name, PluginClass, ns, callback) {
        var packadic = $('body').data('packadic');
        packadic.plugins.register.apply(packadic.plugins, arguments);
    }
    exports.register = register;
    var BasePlugin = (function () {
        function BasePlugin(packadic, element, options, ns) {
            this.VERSION = '0.0.0';
            this.NAMESPACE = 'packadic.';
            this.enabled = true;
            this.packadic = packadic;
            this._options = options;
            this.$window = $(window);
            this.$document = $(document);
            this.$body = $(document.body);
            this.$element = $(element);
            this.NAMESPACE = ns;
            this._trigger('create');
            this._create();
            this._trigger('created');
        }
        Object.defineProperty(BasePlugin.prototype, "options", {
            get: function () {
                return this._options;
            },
            enumerable: true,
            configurable: true
        });
        BasePlugin.register = function (name, PluginClass, ns, callback) {
            register.call(arguments);
        };
        BasePlugin.prototype.instance = function () {
            return this;
        };
        BasePlugin.prototype._create = function () {
        };
        BasePlugin.prototype._destroy = function () {
        };
        BasePlugin.prototype.destroy = function () {
            this._trigger('destroy');
            this._destroy();
            this._trigger('destroyed');
        };
        BasePlugin.prototype._trigger = function (name, extraParameters) {
            var e = $.Event(name + '.' + this.NAMESPACE);
            this.$element.trigger(e, extraParameters);
            return this;
        };
        BasePlugin.prototype._on = function () {
            var args = [];
            for (var _i = 0; _i < arguments.length; _i++) {
                args[_i - 0] = arguments[_i];
            }
            args[0] = args[0] + '.' + this.NAMESPACE;
            debug_1.debug.log('plugin _on ', this, args);
            this.$element.on.apply(this.$element, args);
            return this;
        };
        BasePlugin.defaults = {};
        return BasePlugin;
    })();
    exports.BasePlugin = BasePlugin;
});
