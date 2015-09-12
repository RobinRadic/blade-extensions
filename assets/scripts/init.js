/// <reference path="types.d.ts" />
requirejs.config(window.packadicConfig.requirejs);
requirejs(['Packadic'], function (Packadic) {
    var packadic = window.packadic = Packadic.instance;
    packadic.DEBUG = true;
    packadic.init({});
    packadic.boot();
    packadic.removePageLoader();
});
