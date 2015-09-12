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
})(["require", "exports", 'jquery', 'async', './BaseApp', './modules/utilities', './modules/configuration', './modules/storage', 'svg', './modules/debug'], function (require, exports) {
    var $ = require('jquery');
    var async = require('async');
    var BaseApp_1 = require('./BaseApp');
    var util = require('./modules/utilities');
    var configuration_1 = require('./modules/configuration');
    var storage = require('./modules/storage');
    var svg = require('svg');
    var debug_1 = require('./modules/debug');
    var log = debug_1.debug.log;
    var $window = $(window), $document = $(document), $body = $('body'), $header = $.noop(), $headerInner = $.noop(), $container = $.noop(), $content = $.noop(), $sidebar = $.noop(), $sidebarMenu = $.noop(), $search = $.noop(), $footer = $.noop();
    function assignElements($e) {
        $header = $e('header');
        $headerInner = $e('header-inner');
        $container = $e('container');
        $content = $e('content');
        $sidebar = $e('sidebar');
        $sidebarMenu = $e('sidebar-menu');
        $footer = $e('footer');
        $search = $e('search');
    }
    var Layout = (function (_super) {
        __extends(Layout, _super);
        function Layout() {
            _super.apply(this, arguments);
            this.openCloseInProgress = false;
            this.closing = false;
            this.logo = {};
        }
        Layout.prototype.boot = function () {
            var self = this;
            assignElements(self.p.el.bind(self.p));
            self._initHeader();
            self._initFixed();
            self._initSubmenus();
            self._initToggleButton();
            self._initGoTop();
            self._initPreferences();
            self._initLogo();
            self.sidebarResolveActive();
            self.p.on('resize', function () {
                self._initFixed();
            });
            self.fixBreadcrumb();
        };
        Layout.prototype.setLogoText = function (logoText) {
            window['SVG'] = svg;
            var logo = svg('logo');
            logo.clear();
            logo.size(200, 50)
                .viewbox(0, 0, 200, 50)
                .attr('preserveAspectRatio', 'xMidYMid meet');
            var text = logo.text(logoText);
            var image = logo.image('http://svgjs.com//images/shade.jpg');
            text.attr('dy', '.3em')
                .font({
                family: 'Purisa, Source Code Pro',
                anchor: 'start',
                size: this.config('docgen.logo.size'),
                leading: 1
            })
                .x(this.config('docgen.logo.x'))
                .y(this.config('docgen.logo.y'));
            image
                .size(650, 650)
                .y(-150)
                .x(-150)
                .clipWith(text);
            this.logo = { container: logo, text: text, image: image };
        };
        Layout.prototype._initLogo = function () {
            this.setLogoText(this.config('docgen.logo.text'));
        };
        Layout.prototype._initHeader = function () {
            var self = this;
        };
        Layout.prototype.fixBreadcrumb = function () {
            var $i = $('.page-breadcrumb').find('> li').last().find('i');
            if ($i.size() > 0) {
                $i.remove();
            }
        };
        Layout.prototype._initGoTop = function () {
            var self = this;
            var offset = 300;
            var duration = 500;
            if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
                $window.bind("touchend touchcancel touchleave", function (e) {
                    if ($(this).scrollTop() > offset) {
                        $('.scroll-to-top').fadeIn(duration);
                    }
                    else {
                        $('.scroll-to-top').fadeOut(duration);
                    }
                });
            }
            else {
                $window.scroll(function () {
                    if ($(this).scrollTop() > offset) {
                        $('.scroll-to-top').fadeIn(duration);
                    }
                    else {
                        $('.scroll-to-top').fadeOut(duration);
                    }
                });
            }
            $('.scroll-to-top').click(function (e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, duration);
                return false;
            });
        };
        Layout.prototype._initFixed = function () {
            this.p.destroySlimScroll($sidebarMenu);
            if (!this.isFixed()) {
                return;
            }
            if (this.p.getViewPort().width >= this.p.getBreakpoint('md')) {
                $sidebarMenu.attr("data-height", this.calculateViewportHeight());
                this.p.makeSlimScroll($sidebarMenu);
                $('.page-content').css('min-height', this.calculateViewportHeight() + 'px');
            }
        };
        Layout.prototype._initSubmenus = function () {
            var self = this;
            $sidebar.on('click', 'li > a', function (e) {
                var $this = $(this);
                if (self.p.getViewPort().width >= self.p.getBreakpoint('md') && $this.parents('.page-sidebar-menu-hover-submenu').size() === 1) {
                    return;
                }
                if ($this.next().hasClass('sub-menu') === false) {
                    if (self.p.getViewPort().width < self.p.getBreakpoint('md') && $sidebarMenu.hasClass("in")) {
                        $('.page-header .responsive-toggler').click();
                    }
                    return;
                }
                if ($this.next().hasClass('sub-menu always-open')) {
                    return;
                }
                var $parent = $this.parent().parent();
                var $subMenu = $this.next();
                if (self.config('app.sidebar').keepExpand !== true) {
                    $parent.children('li.open').children('a').children('.arrow').removeClass('open');
                    $parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(self.config('app.sidebar').slideSpeed);
                    $parent.children('li.open').removeClass('open');
                }
                var slideOffeset = -200;
                if ($subMenu.is(":visible")) {
                    $this.find('.arrow').removeClass("open");
                    $this.parent().removeClass("open");
                    $subMenu.slideUp(self.config('app.sidebar').slideSpeed, function () {
                        if (self.config('app.sidebar').autoScroll === true && self.isClosed() === false) {
                            if ($body.hasClass('page-sidebar-fixed')) {
                                $sidebar.slimScroll({
                                    'scrollTo': ($this.position()).top
                                });
                            }
                            else {
                                self.p.scrollTo($this, slideOffeset);
                            }
                        }
                    });
                }
                else {
                    $this.find('.arrow').addClass("open");
                    $this.parent().addClass("open");
                    $subMenu.slideDown(self.config('app.sidebar').slideSpeed, function () {
                        if (self.config('app.sidebar').autoScroll === true && self.isClosed() === false) {
                            if (self.isFixed()) {
                                $sidebar.slimScroll({
                                    'scrollTo': ($this.position()).top
                                });
                            }
                            else {
                                self.p.scrollTo($this, slideOffeset);
                            }
                        }
                    });
                }
                e.preventDefault();
            });
            $document.on('click', '.page-header-fixed-mobile .responsive-toggler', function () {
                self.p.scrollTop();
            });
        };
        Layout.prototype._initToggleButton = function () {
            var self = this;
            $body.on('click', self.config('app.sidebar').togglerSelector, function (e) {
                if (self.isClosed()) {
                    self.openSidebar();
                }
                else {
                    self.closeSidebar();
                }
            });
            self._initFixedHovered();
        };
        Layout.prototype._initFixedHovered = function () {
            var self = this;
            if (self.isFixed()) {
                $sidebarMenu.on('mouseenter', function () {
                    if (self.isClosed()) {
                        $sidebar.removeClass('page-sidebar-menu-closed');
                    }
                }).on('mouseleave', function () {
                    if (self.isClosed()) {
                        $sidebar.addClass('page-sidebar-menu-closed');
                    }
                });
            }
        };
        Object.defineProperty(Layout.prototype, "preferences", {
            get: function () {
                return this._preferences;
            },
            enumerable: true,
            configurable: true
        });
        Layout.prototype._initPreferences = function () {
            var self = this;
            var prefs = this._preferences = new Preferences(this);
            prefs.bind('header.fixed', 'set', this.setHeaderFixed);
            prefs.bind('footer.fixed', 'set', this.setFooterFixed);
            prefs.bind('page.boxed', 'set', this.setBoxed);
            prefs.callAllBindings();
        };
        Layout.prototype.setSidebarClosed = function (closed) {
            if (closed === void 0) { closed = true; }
            $body.ensureClass("page-sidebar-closed", closed);
            $sidebarMenu.ensureClass("page-sidebar-menu-closed", closed);
            if (this.isClosed() && this.isFixed()) {
                $sidebarMenu.trigger("mouseleave");
            }
            $window.trigger('resize');
        };
        Layout.prototype.closeSubmenus = function () {
            var self = this;
            $sidebarMenu.find('ul.sub-menu').each(function () {
                var $ul = $(this);
                if ($ul.is(":visible")) {
                    $('.arrow', $ul).removeClass("open");
                    $ul.parent().removeClass("open");
                    $ul.slideUp(self.config('app.sidebar').slideSpeed);
                }
            });
            this.p.emit('sidebar:close-submenus');
        };
        Layout.prototype.closeSidebar = function (callback) {
            var self = this;
            var $main = $('main');
            if (self.openCloseInProgress || self.isClosed()) {
                return;
            }
            self.openCloseInProgress = true;
            self.closing = true;
            var defer = $.Deferred();
            this.p.emit('sidebar:close');
            self.closeSubmenus();
            var $title = $sidebarMenu.find('li a span.title, li a span.arrow');
            var $content = self.p.el('content');
            async.parallel([
                function (cb) {
                    $content.animate({
                        'margin-left': self.config('app.sidebar').closedWidth
                    }, self.config('app.sidebar').openCloseDuration, function () {
                        cb();
                    });
                },
                function (cb) {
                    $sidebar.animate({
                        width: self.config('app.sidebar').closedWidth
                    }, self.config('app.sidebar').openCloseDuration, function () {
                        cb();
                    });
                },
                function (cb) {
                    var closed = 0;
                    $title.animate({
                        opacity: 0
                    }, self.config('app.sidebar').openCloseDuration / 3, function () {
                        closed++;
                        if (closed == $title.length) {
                            $title.css('display', 'none');
                            cb();
                        }
                    });
                }
            ], function (err, results) {
                self.setSidebarClosed(true);
                $sidebar.removeAttr('style');
                $content.removeAttr('style');
                $title.removeAttr('style');
                self.closing = false;
                self.openCloseInProgress = false;
                if (_.isFunction(callback)) {
                    callback();
                }
                defer.resolve();
                self.p.emit('sidebar:closed');
            });
            return defer.promise();
        };
        Layout.prototype.openSidebar = function (callback) {
            var self = this;
            if (self.openCloseInProgress || !self.isClosed()) {
                return;
            }
            self.openCloseInProgress = true;
            var defer = $.Deferred();
            var $title = $sidebarMenu.find('li a span.title, li a span.arrow');
            var $content = self.p.el('content');
            self.setSidebarClosed(false);
            this.p.emit('sidebar:open');
            async.parallel([
                function (cb) {
                    $content.css('margin-left', self.config('app.sidebar').closedWidth)
                        .animate({
                        'margin-left': self.config('app.sidebar').openedWidth
                    }, self.config('app.sidebar').openCloseDuration, function () {
                        cb();
                    });
                },
                function (cb) {
                    $sidebar.css('width', self.config('app.sidebar').closedWidth)
                        .animate({
                        width: self.config('app.sidebar').openedWidth
                    }, self.config('app.sidebar').openCloseDuration, function () {
                        cb();
                    });
                },
                function (cb) {
                    var opened = 0;
                    $title.css({
                        opacity: 0,
                        display: 'none'
                    });
                    setTimeout(function () {
                        $title.css('display', 'initial');
                        $title.animate({
                            opacity: 1
                        }, self.config('app.sidebar').openCloseDuration / 2, function () {
                            opened++;
                            if (opened == $title.length) {
                                $title.css('display', 'none');
                                cb();
                            }
                        });
                    }, self.config('app.sidebar').openCloseDuration / 2);
                }
            ], function (err, results) {
                $content.removeAttr('style');
                $sidebar.removeAttr('style');
                $title.removeAttr('style');
                self.openCloseInProgress = false;
                if (_.isFunction(callback)) {
                    callback();
                }
                defer.resolve();
                self.p.emit('sidebar:opened');
            });
            return defer.promise();
        };
        Layout.prototype.hideSidebar = function () {
            if (this.preferences.get('sidebar.hidden')) {
                return;
            }
            if (!$body.hasClass('page-sidebar-closed')) {
                $body.addClass('page-sidebar-closed');
            }
            if (!$body.hasClass('page-sidebar-hide')) {
                $body.addClass('page-sidebar-hide');
            }
            $('header.top .sidebar-toggler').hide();
            this.p.emit('sidebar:hide');
        };
        Layout.prototype.showSidebar = function () {
            $body.removeClass('page-sidebar-closed')
                .removeClass('page-sidebar-hide');
            $('header.top .sidebar-toggler').show();
            this.p.emit('sidebar:show');
        };
        Layout.prototype.sidebarResolveActive = function () {
            var self = this;
            if (this.config('app.sidebar.resolveActive') !== true)
                return;
            var currentPath = util.trim(location.pathname.toLowerCase(), '/');
            var md = this.p.getBreakpoint('md');
            if (this.p.getViewPort().width < md) {
                return;
            }
            $sidebarMenu.find('a').each(function () {
                var href = this.getAttribute('href');
                if (!_.isString(href)) {
                    return;
                }
                href = util.trim(href)
                    .replace(location['origin'], '')
                    .replace(/\.\.\//g, '');
                if (location['hostname'] !== 'localhost') {
                    href = self.config('docgen.baseUrl') + href;
                }
                var path = util.trim(href, '/');
                debug_1.debug.log(path, currentPath, href);
                if (path == currentPath) {
                    debug_1.debug.log('Resolved active sidebar link', this);
                    var $el = $(this);
                    $el.parent('li').not('.active').addClass('active');
                    var $parentsLi = $el.parents('li').addClass('open');
                    $parentsLi.find('.arrow').addClass('open');
                    $parentsLi.has('ul').children('ul').show();
                }
            });
        };
        Layout.prototype.setSidebarFixed = function (fixed) {
            $body.ensureClass("page-sidebar-fixed", fixed);
            $sidebarMenu.ensureClass("page-sidebar-menu-fixed", fixed);
            $sidebarMenu.ensureClass("page-sidebar-menu-default", !fixed);
            if (!fixed) {
                $sidebarMenu.unbind('mouseenter').unbind('mouseleave');
            }
            else {
                this._initFixedHovered();
            }
            this._initFixed();
            this.p.emit('sidebar:' + fixed ? 'fix' : 'unfix');
        };
        Layout.prototype.setSidebarCompact = function (compact) {
            $sidebarMenu.ensureClass("page-sidebar-menu-compact", compact);
            this.p.emit('sidebar:' + compact ? 'compact' : 'decompact');
        };
        Layout.prototype.setSidebarHover = function (hover) {
            $sidebarMenu.ensureClass("page-sidebar-menu-hover-submenu", hover && !this.isFixed());
            this.p.emit('sidebar:' + hover ? 'hover' : 'dehover');
        };
        Layout.prototype.setSidebarReversed = function (reversed) {
            $body.ensureClass("page-sidebar-reversed", reversed);
            this.p.emit('sidebar:' + reversed ? 'set-right' : 'set-left');
        };
        Layout.prototype.setHeaderFixed = function (fixed) {
            if (fixed === true) {
                $body.addClass("page-header-fixed");
                $header.removeClass("navbar-static-top").addClass("navbar-fixed-top");
            }
            else {
                $body.removeClass("page-header-fixed");
                $header.removeClass("navbar-fixed-top").addClass("navbar-static-top");
            }
        };
        Layout.prototype.setFooterFixed = function (fixed) {
            if (fixed === true) {
                $body.addClass("page-footer-fixed");
            }
            else {
                $body.removeClass("page-footer-fixed");
            }
        };
        Layout.prototype.setBoxed = function (boxed) {
            if (boxed === true) {
                $body.addClass("page-boxed");
                $headerInner.addClass("container");
                var cont = $('body > .clearfix').after('<div class="container"></div>');
                $container.appendTo('body > .container');
                if (this.preferences.get('footer.fixed')) {
                    $footer.html('<div class="container">' + $footer.html() + '</div>');
                }
                else {
                    $footer.appendTo('body > .container');
                }
                this.p.emit('resize');
            }
        };
        Layout.prototype.reset = function () {
            $body.
                removeClass("page-boxed").
                removeClass("page-footer-fixed").
                removeClass("page-sidebar-fixed").
                removeClass("page-header-fixed").
                removeClass("page-sidebar-reversed");
            $header.removeClass('navbar-fixed-top');
            $headerInner.removeClass("container");
            if ($container.parent(".container").size() === 1) {
                $container.insertAfter('body > .clearfix');
            }
            if ($('.page-footer > .container').size() === 1) {
                $footer.html($('.page-footer > .container').html());
            }
            else if ($footer.parent(".container").size() === 1) {
                $footer.insertAfter($container);
                $('.scroll-to-top').insertAfter($footer);
            }
            $('body > .container').remove();
        };
        Layout.prototype.calculateViewportHeight = function () {
            var self = this;
            var sidebarHeight = util.getViewPort().height - $('.page-header').outerHeight() - 30;
            if ($body.hasClass("page-footer-fixed")) {
                sidebarHeight = sidebarHeight - $footer.outerHeight();
            }
            return sidebarHeight;
        };
        Layout.prototype.isClosed = function () {
            return $body.hasClass('page-sidebar-closed');
        };
        Layout.prototype.isHidden = function () {
            return $body.hasClass('page-sidebar-hide');
        };
        Layout.prototype.isFixed = function () {
            return $('.page-sidebar-fixed').size() !== 0;
        };
        return Layout;
    })(BaseApp_1.BaseApp);
    exports.Layout = Layout;
    var Preferences = (function () {
        function Preferences(layout) {
            this.layout = layout;
            this.p = layout.p;
            this.bindings = new configuration_1.ConfigObject();
            this.defaultPreferences = util.dotize(this.config('app.preferences'));
            this.preferencesKeys = Object.keys(this.defaultPreferences);
        }
        Object.defineProperty(Preferences.prototype, "config", {
            get: function () {
                return this.p.config;
            },
            enumerable: true,
            configurable: true
        });
        Preferences.prototype.save = function (key, val) {
            val = util.def(val, this.config('app.preferences.' + key));
            storage.set('packadic.preference.' + key, val);
            this.set(key, val);
            return this;
        };
        Preferences.prototype.set = function (key, val) {
            this.config.set('app.preferences.' + key, val);
            this.callBindings(key);
            return this;
        };
        Preferences.prototype.get = function (key) {
            return storage.get('packadic.preference.' + key, {
                def: this.config('app.preferences.' + key)
            });
        };
        Preferences.prototype.has = function (key) {
            return this.preferencesKeys.indexOf(key) !== -1;
        };
        Preferences.prototype.all = function () {
            var self = this;
            var all = {};
            this.preferencesKeys.forEach(function (key) {
                all[key] = self.get(key);
            });
            return all;
        };
        Preferences.prototype.bind = function (key, name, callback) {
            this.bindings.set(key + '.' + name, callback);
            return this;
        };
        Preferences.prototype.hasBindings = function (key) {
            return typeof this.bindings.get(key) === 'object' && Object.keys(this.bindings.get(key)).length > 0;
        };
        Preferences.prototype.bound = function (key, name) {
            return typeof this.bindings.get(key + '.' + name) === 'function';
        };
        Preferences.prototype.unbind = function (key, name) {
            this.bindings.unset(key + '.' + name);
            return this;
        };
        Preferences.prototype.callBindings = function (key) {
            var self = this;
            if (this.hasBindings(key)) {
                var val = self.get(key);
                Object.keys(this.bindings.get(key)).forEach(function (name) {
                    var binding = self.bindings.get(key + '.' + name);
                    binding.call(self, val);
                });
            }
            return this;
        };
        Preferences.prototype.callAllBindings = function () {
            var self = this;
            Object.keys(this.all()).forEach(function (key) {
                self.callBindings(key);
            });
            return this;
        };
        Preferences.prototype.getBindings = function () {
            return this.bindings.get();
        };
        return Preferences;
    })();
    exports.Preferences = Preferences;
});
