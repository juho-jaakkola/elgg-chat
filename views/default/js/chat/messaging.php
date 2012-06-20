<?php
/**
 * Gets the unread chat messages via AJAX.
 */
?>

elgg.chat.ready = function() {
	// Get unread messages every 10 seconds
	setInterval(elgg.chat.getUnreadMessages, 10000);
};

/**
 * Get unread messages via AJAX.
 */
elgg.chat.getUnreadMessages = function() {
	var time_created = $('.elgg-chat-messages #timestamp').last().text();
	var guid = $('input:hidden[name=container_guid]').val();

	var url = elgg.normalize_url("mod/chat/messages.php");
	var params = {
		"time_created": time_created,
		"guid": guid
	};
		
	var messages = elgg.get(
		url,
		{
			data: params,
			success: function(data) {
				if (data) {
					// Append messages to discussion
					$('.elgg-chat-messages > .elgg-list').append(data);
				}
			}
		}
	);
}

elgg.register_hook_handler('ready', 'system', elgg.chat.ready);
