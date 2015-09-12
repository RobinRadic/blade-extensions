(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports", './utilities', 'jquery'], function (require, exports) {
    /// <reference path="../types.d.ts" />
    var utilities_1 = require('./utilities');
    var $ = require('jquery');
    var ConfigObject = (function () {
        function ConfigObject(obj) {
            this.allDelimiters = {};
            this.addDelimiters('config', '<%', '%>');
            this.data = obj || {};
        }
        ConfigObject.makeProperty = function (config) {
            var cf = function (prop) {
                return config.get(prop);
            };
            cf.get = config.get.bind(config);
            cf.set = config.set.bind(config);
            cf.unset = config.unset.bind(config);
            cf.merge = config.merge.bind(config);
            cf.raw = config.raw.bind(config);
            cf.process = config.process.bind(config);
            return cf;
        };
        ConfigObject.prototype.unset = function (prop) {
            prop = prop.split('.');
            var key = prop.pop();
            var obj = utilities_1.objectGet(this.data, ConfigObject.getPropString(prop.join('.')));
            delete obj[key];
        };
        ConfigObject.getPropString = function (prop) {
            return Array.isArray(prop) ? prop.map(this.escape).join('.') : prop;
        };
        ConfigObject.escape = function (str) {
            return str.replace(/\./g, '\\.');
        };
        ConfigObject.prototype.raw = function (prop) {
            if (prop) {
                return utilities_1.objectGet(this.data, ConfigObject.getPropString(prop));
            }
            else {
                return this.data;
            }
        };
        ConfigObject.prototype.get = function (prop) {
            return this.process(this.raw(prop));
        };
        ConfigObject.prototype.set = function (prop, value) {
            utilities_1.objectSet(this.data, ConfigObject.getPropString(prop), value);
            return this;
        };
        ConfigObject.prototype.merge = function (obj) {
            this.data = _.merge(this.data, obj);
            return this;
        };
        ConfigObject.prototype.process = function (raw) {
            var self = this;
            return utilities_1.recurse(raw, function (value) {
                if (typeof value !== 'string') {
                    return value;
                }
                var matches = value.match(ConfigObject.propStringTmplRe);
                var result;
                if (matches) {
                    result = self.get(matches[1]);
                    if (result != null) {
                        return result;
                    }
                }
                return self.processTemplate(value, { data: self.data });
            });
        };
        ConfigObject.prototype.addDelimiters = function (name, opener, closer) {
            var delimiters = this.allDelimiters[name] = {};
            delimiters.opener = opener;
            delimiters.closer = closer;
            var a = delimiters.opener.replace(/(.)/g, '\\$1');
            var b = '([\\s\\S]+?)' + delimiters.closer.replace(/(.)/g, '\\$1');
            delimiters.lodash = {
                evaluate: new RegExp(a + b, 'g'),
                interpolate: new RegExp(a + '=' + b, 'g'),
                escape: new RegExp(a + '-' + b, 'g')
            };
        };
        ConfigObject.prototype.setDelimiters = function (name) {
            var delimiters = this.allDelimiters[name in this.allDelimiters ? name : 'config'];
            _.templateSettings = delimiters.lodash;
            return delimiters;
        };
        ConfigObject.prototype.processTemplate = function (tmpl, options) {
            if (!options) {
                options = {};
            }
            var delimiters = this.setDelimiters(options.delimiters);
            var data = Object.create(options.data || this.data || {});
            var last = tmpl;
            try {
                while (tmpl.indexOf(delimiters.opener) >= 0) {
                    tmpl = _.template(tmpl)(data);
                    if (tmpl === last) {
                        break;
                    }
                    last = tmpl;
                }
            }
            catch (e) {
            }
            return tmpl.toString().replace(/\r\n|\n/g, '\n');
        };
        ConfigObject.propStringTmplRe = /^<%=\s*([a-z0-9_$]+(?:\.[a-z0-9_$]+)*)\s*%>$/i;
        return ConfigObject;
    })();
    exports.ConfigObject = ConfigObject;
    var Configuration = (function () {
        function Configuration() {
        }
        Configuration.prototype.setConfig = function (opts, defaults) {
            this._config = new ConfigObject($.extend(true, defaults, opts));
            this.config = ConfigObject.makeProperty(this._config);
        };
        return Configuration;
    })();
    exports.Configuration = Configuration;
});
