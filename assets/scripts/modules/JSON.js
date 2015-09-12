/// <reference path="../types.d.ts" />
(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports"], function (require, exports) {
    var old_json = JSON;
    function stringify(obj) {
        return old_json.stringify(obj, function (key, value) {
            if (value instanceof Function || typeof value == 'function') {
                return value.toString();
            }
            if (value instanceof RegExp) {
                return '_PxEgEr_' + value;
            }
            return value;
        });
    }
    exports.stringify = stringify;
    function parse(str, date2obj) {
        var iso8061 = date2obj ? /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2}(?:\.\d*)?)Z$/ : false;
        return old_json.parse(str, function (key, value) {
            var prefix;
            if (typeof value != 'string') {
                return value;
            }
            if (value.length < 8) {
                return value;
            }
            prefix = value.substring(0, 8);
            if (iso8061 && value.match(iso8061)) {
                return new Date(value);
            }
            if (prefix === 'function') {
                return eval('(' + value + ')');
            }
            if (prefix === '_PxEgEr_') {
                return eval(value.slice(8));
            }
            return value;
        });
    }
    exports.parse = parse;
    function clone(obj, date2obj) {
        return parse(stringify(obj), date2obj);
    }
    exports.clone = clone;
});
