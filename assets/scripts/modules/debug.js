(function (deps, factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(deps, factory);
    }
})(["require", "exports", './../modules/material', './../modules/utilities'], function (require, exports) {
    var material = require('./../modules/material');
    var utilities_1 = require('./../modules/utilities');
    var StyleStuff = (function () {
        function StyleStuff() {
            this._styles = {};
        }
        StyleStuff.prototype.addMSC = function (name, variant) {
            if (variant === void 0) { variant = '500'; }
            if (typeof name === 'string') {
                if (variant !== '500') {
                    name += variant.toString();
                }
                this._styles[name.toString()] = 'color: ' + material.color(name.toString(), variant);
            }
            else {
                name.forEach(function (n) {
                    this.addMSC(n, variant);
                }.bind(this));
            }
            return this;
        };
        StyleStuff.prototype.addFont = function (name, ff) {
            this._styles[name] = 'font-family: ' + ff;
            return this;
        };
        StyleStuff.prototype.add = function (name, val) {
            if (typeof val === 'string') {
                this._styles[name] = val;
            }
            else {
                var css = '';
                val.forEach(function (v) {
                    if (typeof this._styles[v] === 'string') {
                        css += this._styles[v] + ';';
                    }
                    else {
                        css += v + ';';
                    }
                }.bind(this));
                this._styles[name] = css;
            }
            return this;
        };
        StyleStuff.prototype.all = function () {
            return this._styles;
        };
        StyleStuff.prototype.get = function (name) {
            return this._styles[name];
        };
        StyleStuff.prototype.has = function (name) {
            return typeof this._styles[name] === 'string';
        };
        return StyleStuff;
    })();
    var Debug = (function () {
        function Debug() {
            this.matcher = /\[style\=([\w\d\_\-\,]*?)\](.*?)\[style\]/g;
            this.start = new Date;
            this.styles = new StyleStuff();
            this.enabled = false;
            for (var i = 8; i < 30; i++) {
                this.styles.add('fs' + i.toString(), 'font-size: ' + i.toString() + 'px');
            }
            this.styles
                .add('bold', 'font-weight:bold')
                .add('code-box', 'background: rgb(255, 255, 219); padding: 1px 5px; border: 1px solid rgba(0, 0, 0, 0.1); line-height: 18px')
                .addMSC(Object.keys(material.colors))
                .addFont('code', '"Source Code Pro", "Courier New", Courier, monospace')
                .addFont('arial', 'Arial, Helvetica, sans-serif')
                .addFont('verdana', 'Verdana, Geneva, sans-serif');
        }
        Debug.prototype.printTitle = function () {
            this.out('[style=orange,fs25]Packadic Framework[style] [style=yellow]1.0.0[style]');
        };
        Debug.prototype.log = function () {
            var args = [];
            for (var _i = 0; _i < arguments.length; _i++) {
                args[_i - 0] = arguments[_i];
            }
            var elapsedTime = Date.now() - this.start.getTime();
            if (elapsedTime > 1) {
                elapsedTime = utilities_1.round(elapsedTime / 1000, 2);
            }
            this.out.apply(this, ['[style=orange,fs10]DEBUG[style]([style=green,fs8]' + elapsedTime + '[style]): '].concat(args));
        };
        Debug.prototype.logEvent = function (eventName) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            var elapsedTime = Date.now() - this.start.getTime();
            if (elapsedTime > 1) {
                elapsedTime = utilities_1.round(elapsedTime / 1000, 2);
            }
            this.out.apply(this, ['[style=orange,fs10]DEBUG[style]([style=green,fs8]' + elapsedTime + '[style]):[style=teal,fs10]EVENT[style]([style=blue,fs8]' + eventName + '[style]): '].concat(args));
        };
        Debug.prototype.out = function (message) {
            var args = [];
            for (var _i = 1; _i < arguments.length; _i++) {
                args[_i - 1] = arguments[_i];
            }
            var self = this;
            var applyArgs = [];
            applyArgs.push(message.replace(this.matcher, '%c$2%c'));
            var matched;
            while ((matched = this.matcher.exec(message)) !== null) {
                var css = '';
                matched[1].split(',').forEach(function (style) {
                    css += self.styles.get(style) + ';';
                });
                applyArgs.push(css);
                applyArgs.push('');
            }
            if (this.enabled) {
                console.log.apply(console, applyArgs.concat(args));
            }
        };
        Debug.prototype.enable = function () {
            if (this.enabled) {
                return;
            }
            this.enabled = true;
            this.printTitle();
        };
        Debug.prototype.isEnabled = function () {
            return this.enabled;
        };
        Debug.prototype.setStartDate = function (start) {
            this.start = start;
            return this;
        };
        return Debug;
    })();
    exports.Debug = Debug;
    exports.debug = new Debug();
});
