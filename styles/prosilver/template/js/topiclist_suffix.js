;(function($, window, document) {
	$('span.marttiphpbb-topicsuffixtags-topicrow').each(function(){
		$(this).insertAfter($(this).parent().find('a.topictitle').eq(0));
		$(this).show();
	});
})(jQuery, window, document);
