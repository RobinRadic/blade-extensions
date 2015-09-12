define(['ace/ace', 'ace/ext/beautify', 'ace/ext/emmet', 'ace/ext/searchbox', 'ace/ext/settings_menu', 'ace/ext/modelist', 'ace/ext/themelist', 'ace/ext/language_tools', 'ace/theme/kuroir',
    'ace/mode/markdown', 'ace/mode/php', 'ace/mode/javascript', 'ace/mode/jade'], function (ace, beautify, emmet, searchbox, settings_menu, modelist, themelist, language_tools) {
    return {
        ace: ace,
        beautify: beautify,
        emmet: emmet,
        searchbox: searchbox,
        settings_menu: settings_menu,
        modelist: modelist,
        themelist: themelist,
        language_tools: language_tools
    };
});
