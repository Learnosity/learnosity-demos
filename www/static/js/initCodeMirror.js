/*global $, CodeMirror, _ */
$(function(){

	/* ,jsonexample codemirror */
	var jsonSnippet = $('.jsonexample');
	_.forEach(jsonSnippet, function(elm, index) {
		$(elm).addClass('cm-s-default');
		CodeMirror.runMode(elm.innerHTML, {name: "javascript", json: true}, elm);
	});

	/* jsexample codemirror */
	var jSnippet = $('.jsexample');
	_.forEach(jSnippet, function(elm, index) {
		$(elm).addClass('cm-s-default');
		CodeMirror.runMode(elm.innerHTML, {name: "javascript"}, elm);
	});

	/* ,htmlexample codemirror */
	var htmlSnippet = $('.htmlexample');
	_.forEach(htmlSnippet, function(elm, index) {
		$(elm).addClass('cm-s-default');
		var code = elm.innerHTML;
		code = code.replace(/&lt;/gi, '<');
		code = code.replace(/&gt;/gi, '>');
		CodeMirror.runMode(code, {name: "htmlmixed"}, elm);
	});

	/* ,phpexample codemirror */
	var phpSnippet = $('.phpexample');
	_.forEach(phpSnippet, function(elm, index) {
		$(elm).addClass('cm-s-default');
		var code = elm.innerHTML;
		code = code.replace(/&lt;/gi, '<');
		code = code.replace(/&gt;/gi, '>');
        code = code.replace(/&amp;/gi, '&');
		CodeMirror.runMode(code, "text/x-php", elm);
	});
});