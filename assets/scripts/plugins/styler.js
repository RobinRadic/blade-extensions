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
})(["require", "exports", "x-editable", "spectrum", 'jquery', './../modules/material', 'templates/styler', './../plugins', './../modules/debug'], function (require, exports) {
    /// <reference path="./../../types.d.ts" />
    var $ = require('jquery');
    var material = require('./../modules/material');
    var template = require('templates/styler');
    var plugins_1 = require('./../plugins');
    var debug_1 = require('./../modules/debug');
    var log = debug_1.debug.log;
    var colorValues = [];
    var palette = [];
    $.each(material.colors, function (name, variants) {
        var variantValues = [];
        $.each(variants, function (variant, colorCode) {
            colorValues.push(colorCode);
            variantValues.push(colorCode);
        });
        palette.push(variantValues);
    });
    var StylerPlugin = (function (_super) {
        __extends(StylerPlugin, _super);
        function StylerPlugin() {
            _super.apply(this, arguments);
            this.VERSION = '0.0.1';
        }
        StylerPlugin.prototype._getVariables = function () {
            return $.ajax({
                url: this.options.host.toString() + ':' + this.options.port.toString()
            });
        };
        StylerPlugin.prototype.refresh = function () {
            var self = this;
            self._getVariables().done(function (res) {
                if (res.code === 200) {
                    self._bindTemplate(res.data);
                    self._bindXEditable(self.$element.find('a.scss-variable-value'));
                }
            });
        };
        StylerPlugin.prototype._create = function () {
            var self = this;
            self._prepareXEditable();
            self.refresh();
        };
        StylerPlugin.prototype._bindTemplate = function (data) {
            var self = this;
            self.$element.html(template(data));
            self.$element.find('a.styler-var-default').tooltip({ title: 'Marked as default', container: 'body' });
            self.$element.find('a.styler-var-overides, a.styler-var-overidden').tooltip({
                title: function () {
                    console.log(this);
                    var stylerVar = $(this).closest('tr').data('styler-var');
                    if (stylerVar.overides) {
                        return 'Overrides: ' + stylerVar.other;
                    }
                    else if (stylerVar.overidden) {
                        return 'Overidden from: ' + stylerVar.other;
                    }
                },
                html: true,
                container: 'body'
            });
        };
        StylerPlugin.prototype._bindXEditable = function ($el) {
            var self = this;
            $el.on('init', function (event, editable) {
                var $this = $(this);
                var fileName = $this.data('scss-file-name');
                var varName = $this.attr('id');
                editable.options.pk = {
                    fileName: fileName,
                    varName: varName
                };
                editable.options.title = varName;
            });
            $el.on('shown', function (event, editable) {
                debug_1.debug.log(arguments);
                if (editable.input.type === 'color') {
                    editable.input.$input.parent().spectrum('set', editable.value);
                }
            });
            $el.editable({
                url: this.options.host + ':' + this.options.port.toString(),
                success: function (response, newValue) {
                    debug_1.debug.log('editable resp', response, newValue);
                    response.result.files.forEach(function (file) {
                        var $el = $('link[data-styler="' + file.baseName + '"]').first();
                        debug_1.debug.log('$el link editing: ', $el);
                        $el.attr('href', self.packadic.config('paths.assets') + '/styles/' + file.relPath);
                    });
                }
            });
        };
        StylerPlugin.prototype._prepareXEditable = function () {
            $.fn.editable.defaults.mode = 'inline';
            $.fn['editableform'].buttons = $.fn['editableform'].buttons
                .replace('glyphicon glyphicon-ok', 'fa fa-fw fa-check')
                .replace('glyphicon glyphicon-remove', 'fa fa-fw fa-times');
            function Color(options) {
                this.init('color', options, Color['defaults']);
            }
            $.fn['editableutils'].inherit(Color, $.fn['editabletypes'].abstractinput);
            $.extend(Color.prototype, {
                render: function () {
                    var $input = this.$input = this['$tpl'].find('input');
                    $input.parent().spectrum({
                        showPalette: true,
                        palette: palette,
                        containerClassName: 'sp-packadic-styler',
                        showSelectionPalette: true,
                        showInitial: true,
                        showInput: true,
                        showAlpha: false,
                        flat: true,
                        show: function (color) {
                            $(this).spectrum('reflow');
                        },
                        change: function (color) {
                            $(this).find('input').val(color.toHexString().toUpperCase());
                        },
                        preferredFormat: "hex",
                    });
                },
                autosubmit: function () {
                    this.$input.keydown(function (e) {
                        if (e.which === 13) {
                            $(this).closest('form').submit();
                        }
                    });
                }
            });
            Color['defaults'] = $.extend({}, $.fn['editabletypes'].abstractinput.defaults, {
                tpl: '<div class="editable-color"><input type="hidden" class="form-control" value="" /></div>'
            });
            $.fn['editabletypes'].color = Color;
        };
        StylerPlugin.prototype.echo = function () {
            debug_1.debug.log('ECHOING', arguments);
        };
        StylerPlugin.defaults = {
            port: 3000,
            host: 'http://127.0.0.1'
        };
        return StylerPlugin;
    })(plugins_1.BasePlugin);
    exports.StylerPlugin = StylerPlugin;
    plugins_1.register('styler', StylerPlugin);
});
