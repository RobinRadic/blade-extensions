(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports", './modules/debug'], function (require, exports) {
    var debug_1 = require('./modules/debug');
    var log = debug_1.debug.log;
    var BaseApp = (function () {
        function BaseApp(p) {
            this.p = p;
            p.on('make', this._make.bind(this));
            p.on('init', this._init.bind(this));
            p.on('boot', this._boot.bind(this));
            p.on('booted', this._booted.bind(this));
        }
        Object.defineProperty(BaseApp.prototype, "config", {
            get: function () {
                return this.p.config;
            },
            enumerable: true,
            configurable: true
        });
        BaseApp.prototype._make = function () {
            this.make();
        };
        BaseApp.prototype._init = function () {
            this.init();
        };
        BaseApp.prototype._boot = function () {
            this.boot();
        };
        BaseApp.prototype._booted = function () {
            this.booted();
        };
        BaseApp.prototype.make = function () {
        };
        BaseApp.prototype.init = function () {
        };
        BaseApp.prototype.boot = function () {
        };
        BaseApp.prototype.booted = function () {
        };
        return BaseApp;
    })();
    exports.BaseApp = BaseApp;
});
