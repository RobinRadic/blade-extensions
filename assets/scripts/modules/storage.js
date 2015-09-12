(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports", './utilities', './JSON'], function (require, exports) {
    ///<reference path="../types.d.ts"/>
    var utilities_1 = require('./utilities');
    var JSON = require('./JSON');
    function on(callback) {
        if (window.addEventListener) {
            window.addEventListener("storage", callback, false);
        }
        else {
            window.attachEvent("onstorage", callback);
        }
    }
    exports.on = on;
    function set(key, val, options) {
        var options = _.merge({ json: false, expires: false }, options);
        if (options.json) {
            val = JSON.stringify(val);
        }
        if (options.expires) {
            var now = Math.floor((Date.now() / 1000) / 60);
            window.localStorage.setItem(key + ':expire', now + options.expires);
        }
        window.localStorage.setItem(key, val);
    }
    exports.set = set;
    function get(key, options) {
        var options = _.merge({ json: false, def: null }, options);
        if (!utilities_1.defined(key)) {
            return options.def;
        }
        if (_.isString(window.localStorage.getItem(key))) {
            if (_.isString(window.localStorage.getItem(key + ':expire'))) {
                var now = Math.floor((Date.now() / 1000) / 60);
                var expires = parseInt(window.localStorage.getItem(key + ':expire'));
                if (now > expires) {
                    del(key);
                    del(key + ':expire');
                }
            }
        }
        var val = window.localStorage.getItem(key);
        if (!utilities_1.defined(val) || utilities_1.defined(val) && val == null) {
            return options.def;
        }
        if (options.json) {
            return JSON.parse(val);
        }
        return val;
    }
    exports.get = get;
    function del(key) {
        window.localStorage.removeItem(key);
    }
    exports.del = del;
    function clear() {
        window.localStorage.clear();
    }
    exports.clear = clear;
    function getSize(key) {
        key = key || false;
        if (key) {
            return ((localStorage[x].length * 2) / 1024 / 1024).toFixed(2);
        }
        else {
            var total = 0;
            for (var x in localStorage) {
                total += (localStorage[x].length * 2) / 1024 / 1024;
            }
            return total.toFixed(2);
        }
    }
    exports.getSize = getSize;
    exports.storage = {
        on: on,
        get: get,
        set: set,
        del: del,
        clear: clear,
        getSize: getSize,
    };
});
