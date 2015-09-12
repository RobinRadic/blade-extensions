(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports"], function (require, exports) {
    var kindsOf = {};
    'Number String Boolean Function RegExp Array Date Error'.split(' ').forEach(function (k) {
        kindsOf['[object ' + k + ']'] = k.toLowerCase();
    });
    var nativeTrim = String.prototype.trim;
    var entityMap = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': '&quot;',
        "'": '&#39;',
        "/": '&#x2F;'
    };
    function kindOf(value) {
        if (value == null) {
            return String(value);
        }
        return kindsOf[kindsOf.toString.call(value)] || 'object';
    }
    exports.kindOf = kindOf;
    function round(value, places) {
        var multiplier = Math.pow(10, places);
        return (Math.round(value * multiplier) / multiplier);
    }
    exports.round = round;
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
    exports.ucfirst = ucfirst;
    function makeString(object) {
        if (object == null)
            return '';
        return '' + object;
    }
    exports.makeString = makeString;
    function strEndsWith(str, suffix) {
        return str.indexOf(suffix, str.length - suffix.length) !== -1;
    }
    exports.strEndsWith = strEndsWith;
    function escapeRegExp(str) {
        return makeString(str).replace(/([.*+?^=!:${}()|[\]\/\\])/g, '\\$1');
    }
    exports.escapeRegExp = escapeRegExp;
    function defaultToWhiteSpace(characters) {
        if (characters == null)
            return '\\s';
        else if (characters.source)
            return characters.source;
        else
            return '[' + escapeRegExp(characters) + ']';
    }
    exports.defaultToWhiteSpace = defaultToWhiteSpace;
    function trim(str, characters) {
        str = makeString(str);
        if (!characters && nativeTrim)
            return nativeTrim.call(str);
        characters = defaultToWhiteSpace(characters);
        return str.replace(new RegExp('^' + characters + '+|' + characters + '+$', 'g'), '');
    }
    exports.trim = trim;
    function unquote(str, quoteChar) {
        if (quoteChar === void 0) { quoteChar = '"'; }
        if (str[0] === quoteChar && str[str.length - 1] === quoteChar)
            return str.slice(1, str.length - 1);
        else
            return str;
    }
    exports.unquote = unquote;
    function def(val, def) {
        return defined(val) ? val : def;
    }
    exports.def = def;
    function defined(obj) {
        return !_.isUndefined(obj);
    }
    exports.defined = defined;
    function cre(name) {
        if (!defined(name)) {
            name = 'div';
        }
        return $(document.createElement(name));
    }
    exports.cre = cre;
    function getParts(str) {
        return str.replace(/\\\./g, '\uffff').split('.').map(function (s) {
            return s.replace(/\uffff/g, '.');
        });
    }
    exports.getParts = getParts;
    function objectGet(obj, parts, create) {
        if (typeof parts === 'string') {
            parts = getParts(parts);
        }
        var part;
        while (typeof obj === 'object' && obj && parts.length) {
            part = parts.shift();
            if (!(part in obj) && create) {
                obj[part] = {};
            }
            obj = obj[part];
        }
        return obj;
    }
    exports.objectGet = objectGet;
    function objectSet(obj, parts, value) {
        parts = getParts(parts);
        var prop = parts.pop();
        obj = objectGet(obj, parts, true);
        if (obj && typeof obj === 'object') {
            return (obj[prop] = value);
        }
    }
    exports.objectSet = objectSet;
    function objectExists(obj, parts) {
        parts = getParts(parts);
        var prop = parts.pop();
        obj = objectGet(obj, parts);
        return typeof obj === 'object' && obj && prop in obj;
    }
    exports.objectExists = objectExists;
    function recurse(value, fn, fnContinue) {
        function recurse(value, fn, fnContinue, state) {
            var error;
            if (state.objs.indexOf(value) !== -1) {
                error = new Error('Circular reference detected (' + state.path + ')');
                error.path = state.path;
                throw error;
            }
            var obj, key;
            if (fnContinue && fnContinue(value) === false) {
                return value;
            }
            else if (kindOf(value) === 'array') {
                return value.map(function (item, index) {
                    return recurse(item, fn, fnContinue, {
                        objs: state.objs.concat([value]),
                        path: state.path + '[' + index + ']',
                    });
                });
            }
            else if (kindOf(value) === 'object') {
                obj = {};
                for (key in value) {
                    obj[key] = recurse(value[key], fn, fnContinue, {
                        objs: state.objs.concat([value]),
                        path: state.path + (/\W/.test(key) ? '["' + key + '"]' : '.' + key),
                    });
                }
                return obj;
            }
            else {
                return fn(value);
            }
        }
        return recurse(value, fn, fnContinue, { objs: [], path: '' });
    }
    exports.recurse = recurse;
    function copyObject(object) {
        var objectCopy = {};
        for (var key in object) {
            if (object.hasOwnProperty(key)) {
                objectCopy[key] = object[key];
            }
        }
        return objectCopy;
    }
    exports.copyObject = copyObject;
    function getViewPort() {
        var e = window, a = 'inner';
        if (!('innerWidth' in window)) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return {
            width: e[a + 'Width'],
            height: e[a + 'Height']
        };
    }
    exports.getViewPort = getViewPort;
    function isTouchDevice() {
        try {
            document.createEvent("TouchEvent");
            return true;
        }
        catch (e) {
            return false;
        }
    }
    exports.isTouchDevice = isTouchDevice;
    function getRandomId(length) {
        if (!_.isNumber(length)) {
            length = 15;
        }
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }
    exports.getRandomId = getRandomId;
    function applyMixins(derivedCtor, baseCtors) {
        baseCtors.forEach(function (baseCtor) {
            Object.getOwnPropertyNames(baseCtor.prototype).forEach(function (name) {
                derivedCtor.prototype[name] = baseCtor.prototype[name];
            });
        });
    }
    exports.applyMixins = applyMixins;
    function addJqueryUtils() {
        if (kindOf($.fn.prefixedData) === 'function') {
            return;
        }
        $.fn.prefixedData = function (prefix) {
            var origData = $(this).first().data();
            var data = {};
            for (var p in origData) {
                var pattern = new RegExp("^" + prefix + "[A-Z]+");
                if (origData.hasOwnProperty(p) && pattern.test(p)) {
                    var shortName = p[prefix.length].toLowerCase() + p.substr(prefix.length + 1);
                    data[shortName] = origData[p];
                }
            }
            return data;
        };
        $.fn.removeAttributes = function () {
            return this.each(function () {
                var attributes = $.map(this.attributes, function (item) {
                    return item.name;
                });
                var img = $(this);
                $.each(attributes, function (i, item) {
                    img.removeAttr(item);
                });
            });
        };
        $.fn.ensureClass = function (clas, has) {
            if (has === void 0) { has = true; }
            var $this = $(this);
            if (has === true && $this.hasClass(clas) === false) {
                $this.addClass(clas);
            }
            else if (has === false && $this.hasClass(clas) === true) {
                $this.removeClass(clas);
            }
            return this;
        };
    }
    exports.addJqueryUtils = addJqueryUtils;
    function dotize(obj, prefix) {
        if (!obj || typeof obj != "object") {
            if (prefix) {
                var newObj = {};
                newObj[prefix] = obj;
                return newObj;
            }
            else
                return obj;
        }
        var newObj = {};
        function recurse(o, p, isArrayItem) {
            for (var f in o) {
                if (o[f] && typeof o[f] === "object") {
                    if (Array.isArray(o[f]))
                        newObj = recurse(o[f], (p ? p : "") + (isNumber(f) ? "[" + f + "]" : "." + f), true);
                    else {
                        if (isArrayItem)
                            newObj = recurse(o[f], (p ? p : "") + "[" + f + "]");
                        else
                            newObj = recurse(o[f], (p ? p + "." : "") + f);
                    }
                }
                else {
                    if (isArrayItem || isNumber(f))
                        newObj[p + "[" + f + "]"] = o[f];
                    else
                        newObj[(p ? p + "." : "") + f] = o[f];
                }
            }
            if (isEmptyObj(newObj))
                return obj;
            return newObj;
        }
        function isNumber(f) {
            return !isNaN(parseInt(f));
        }
        function isEmptyObj(obj) {
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop))
                    return false;
            }
            return true;
        }
        return recurse(obj, prefix);
    }
    exports.dotize = dotize;
    function escapeHtml(string) {
        return String(string).replace(/[&<>"'\/]/g, function (s) {
            return entityMap[s];
        });
    }
    exports.escapeHtml = escapeHtml;
});
