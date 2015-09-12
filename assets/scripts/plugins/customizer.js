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
})(["require", "exports", "bootstrap-switch", 'jquery', './../plugins', './../modules/debug', 'templates/customizer'], function (require, exports) {
    /// <reference path="../../types.d.ts" />
    var $ = require('jquery');
    var plugins_1 = require('./../plugins');
    var debug_1 = require('./../modules/debug');
    var template = require('templates/customizer');
    var CustomizerPlugin = (function (_super) {
        __extends(CustomizerPlugin, _super);
        function CustomizerPlugin() {
            _super.apply(this, arguments);
        }
        Object.defineProperty(CustomizerPlugin.prototype, "prefs", {
            get: function () {
                return this.packadic.layout.preferences;
            },
            enumerable: true,
            configurable: true
        });
        CustomizerPlugin.prototype._create = function () {
            debug_1.debug.log('loaded customizer ' + this);
            this.refresh();
        };
        CustomizerPlugin.prototype.refresh = function () {
            var self = this;
            this.$element = $(template({
                options: self.options,
                prefs: self.prefs.all(),
                definitions: self.packadic.config.get('app.customizer.definitions')
            }));
            $(this.options.appendTo).append(this.$element);
            this.$element.find('.customizer-toggler').on('click', function (e) {
                e.preventDefault();
                self.$element.toggleClass('active');
            });
            this.$element.find('form input[type="checkbox"].switch').bootstrapSwitch({
                offColor: 'primary', offText: 'NO', onColor: 'info', onText: 'YES'
            }).on('switchChange.bootstrapSwitch', this._onPreferenceControlChange);
            this.$element.find('form [data-preference]').on('change', function (e) {
                debug_1.debug.log('pref change', e, this);
            });
            this.packadic.makeSlimScroll(this.$element.find('.panel-form-container'), {
                height: self.options.contentHeight
            });
        };
        CustomizerPlugin.prototype._onPreferenceControlChange = function (event, state) {
            debug_1.debug.log('pref change switch', event, state, this);
            var pref = $(this).data('preference');
            var packadic = $('body').data('packadic');
            packadic.layout.preferences.set(pref.name, state);
        };
        CustomizerPlugin.defaults = {
            appendTo: 'body',
            contentHeight: 300
        };
        return CustomizerPlugin;
    })(plugins_1.BasePlugin);
    exports.CustomizerPlugin = CustomizerPlugin;
    plugins_1.register('customizer', CustomizerPlugin);
});
