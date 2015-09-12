define(['jade'], function(jade) { if(jade && jade['runtime'] !== undefined) { jade = jade.runtime; }

return function template(locals) {
var buf = [];
var jade_mixins = {};
var jade_interp;
;var locals_for_with = (locals || {});(function (files, undefined, vars) {
buf.push("<div class=\"row\"><div class=\"col-md-12\"><div class=\"tabbable\"><ul class=\"nav nav-tabs\">");
// iterate files
;(function(){
  var $$obj = files;
  if ('number' == typeof $$obj.length) {

    for (var i = 0, $$l = $$obj.length; i < $$l; i++) {
      var file = $$obj[i];

var liClass = (i === 0 ? 'active' : '');
buf.push("<li" + (jade.cls([liClass], [true])) + "><a data-toggle=\"tab\"" + (jade.attr("href", '#styler_file_tab_' + i, true, false)) + " aria-expanded=\"true\"><i class=\"color-green-500 tab-icon fa fa-pencil-square-o\"></i> " + (jade.escape((jade_interp = file) == null ? '' : jade_interp)) + "</a></li>");
    }

  } else {
    var $$l = 0;
    for (var i in $$obj) {
      $$l++;      var file = $$obj[i];

var liClass = (i === 0 ? 'active' : '');
buf.push("<li" + (jade.cls([liClass], [true])) + "><a data-toggle=\"tab\"" + (jade.attr("href", '#styler_file_tab_' + i, true, false)) + " aria-expanded=\"true\"><i class=\"color-green-500 tab-icon fa fa-pencil-square-o\"></i> " + (jade.escape((jade_interp = file) == null ? '' : jade_interp)) + "</a></li>");
    }

  }
}).call(this);

buf.push("</ul><div class=\"tab-content p-n\">");
// iterate files
;(function(){
  var $$obj = files;
  if ('number' == typeof $$obj.length) {

    for (var iFile = 0, $$l = $$obj.length; iFile < $$l; iFile++) {
      var file = $$obj[iFile];

buf.push("<div" + (jade.attr("id", 'styler_file_tab_' + iFile, true, false)) + (jade.cls(['tab-pane','fade',(iFile === 0 ? 'active in':'')], [null,null,true])) + "><table class=\"table table-hover table-condensed table-striped table-codex styler-table\"><thead><tr><th width=\"70\" class=\"text-center\">D</th><th>Variable</th><th>Value</th></tr></thead><tbody>");
// iterate vars.tree[file]
;(function(){
  var $$obj = vars.tree[file];
  if ('number' == typeof $$obj.length) {

    for (var $index = 0, $$l = $$obj.length; $index < $$l; $index++) {
      var variable = $$obj[$index];

buf.push("<tr" + (jade.attr("data-styler-var", variable, true, false)) + "><td class=\"text-center\">");
if ( variable.default)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-default mr-sm\"><i class=\"fa fa-check color-green-500\"></i></a>");
}
if ( variable.overides)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overides mr-sm\"><i class=\"fa fa-floppy-o color-orange-500\"></i></a>");
}
if ( variable.overidden)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overidden mr-sm\"><i class=\"fa fa-remove color-red-400\"></i></a>");
}
buf.push("</td><td><span class=\"scss-variable-name\">" + (jade.escape(null == (jade_interp = variable.name) ? "" : jade_interp)) + "</span></td><td>");
if ( variable.overidden)
{
buf.push("<span class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</span>");
}
else
{
buf.push("<a" + (jade.attr("id", variable.name, true, false)) + (jade.attr("data-type", variable.type, true, false)) + (jade.attr("data-scss-file-name", file, true, false)) + " class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</a>");
}
buf.push("</td></tr>");
    }

  } else {
    var $$l = 0;
    for (var $index in $$obj) {
      $$l++;      var variable = $$obj[$index];

buf.push("<tr" + (jade.attr("data-styler-var", variable, true, false)) + "><td class=\"text-center\">");
if ( variable.default)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-default mr-sm\"><i class=\"fa fa-check color-green-500\"></i></a>");
}
if ( variable.overides)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overides mr-sm\"><i class=\"fa fa-floppy-o color-orange-500\"></i></a>");
}
if ( variable.overidden)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overidden mr-sm\"><i class=\"fa fa-remove color-red-400\"></i></a>");
}
buf.push("</td><td><span class=\"scss-variable-name\">" + (jade.escape(null == (jade_interp = variable.name) ? "" : jade_interp)) + "</span></td><td>");
if ( variable.overidden)
{
buf.push("<span class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</span>");
}
else
{
buf.push("<a" + (jade.attr("id", variable.name, true, false)) + (jade.attr("data-type", variable.type, true, false)) + (jade.attr("data-scss-file-name", file, true, false)) + " class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</a>");
}
buf.push("</td></tr>");
    }

  }
}).call(this);

buf.push("</tbody></table></div>");
    }

  } else {
    var $$l = 0;
    for (var iFile in $$obj) {
      $$l++;      var file = $$obj[iFile];

buf.push("<div" + (jade.attr("id", 'styler_file_tab_' + iFile, true, false)) + (jade.cls(['tab-pane','fade',(iFile === 0 ? 'active in':'')], [null,null,true])) + "><table class=\"table table-hover table-condensed table-striped table-codex styler-table\"><thead><tr><th width=\"70\" class=\"text-center\">D</th><th>Variable</th><th>Value</th></tr></thead><tbody>");
// iterate vars.tree[file]
;(function(){
  var $$obj = vars.tree[file];
  if ('number' == typeof $$obj.length) {

    for (var $index = 0, $$l = $$obj.length; $index < $$l; $index++) {
      var variable = $$obj[$index];

buf.push("<tr" + (jade.attr("data-styler-var", variable, true, false)) + "><td class=\"text-center\">");
if ( variable.default)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-default mr-sm\"><i class=\"fa fa-check color-green-500\"></i></a>");
}
if ( variable.overides)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overides mr-sm\"><i class=\"fa fa-floppy-o color-orange-500\"></i></a>");
}
if ( variable.overidden)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overidden mr-sm\"><i class=\"fa fa-remove color-red-400\"></i></a>");
}
buf.push("</td><td><span class=\"scss-variable-name\">" + (jade.escape(null == (jade_interp = variable.name) ? "" : jade_interp)) + "</span></td><td>");
if ( variable.overidden)
{
buf.push("<span class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</span>");
}
else
{
buf.push("<a" + (jade.attr("id", variable.name, true, false)) + (jade.attr("data-type", variable.type, true, false)) + (jade.attr("data-scss-file-name", file, true, false)) + " class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</a>");
}
buf.push("</td></tr>");
    }

  } else {
    var $$l = 0;
    for (var $index in $$obj) {
      $$l++;      var variable = $$obj[$index];

buf.push("<tr" + (jade.attr("data-styler-var", variable, true, false)) + "><td class=\"text-center\">");
if ( variable.default)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-default mr-sm\"><i class=\"fa fa-check color-green-500\"></i></a>");
}
if ( variable.overides)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overides mr-sm\"><i class=\"fa fa-floppy-o color-orange-500\"></i></a>");
}
if ( variable.overidden)
{
buf.push("<a href=\"javascript:;\" class=\"styler-var-overidden mr-sm\"><i class=\"fa fa-remove color-red-400\"></i></a>");
}
buf.push("</td><td><span class=\"scss-variable-name\">" + (jade.escape(null == (jade_interp = variable.name) ? "" : jade_interp)) + "</span></td><td>");
if ( variable.overidden)
{
buf.push("<span class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</span>");
}
else
{
buf.push("<a" + (jade.attr("id", variable.name, true, false)) + (jade.attr("data-type", variable.type, true, false)) + (jade.attr("data-scss-file-name", file, true, false)) + " class=\"scss-variable-value\">" + (jade.escape(null == (jade_interp = variable.value) ? "" : jade_interp)) + "</a>");
}
buf.push("</td></tr>");
    }

  }
}).call(this);

buf.push("</tbody></table></div>");
    }

  }
}).call(this);

buf.push("</div></div></div></div>");}.call(this,"files" in locals_for_with?locals_for_with.files:typeof files!=="undefined"?files:undefined,"undefined" in locals_for_with?locals_for_with.undefined:typeof undefined!=="undefined"?undefined:undefined,"vars" in locals_for_with?locals_for_with.vars:typeof vars!=="undefined"?vars:undefined));;return buf.join("");
}

});