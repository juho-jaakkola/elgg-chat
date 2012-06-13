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
	var url = elgg.normalize_url("mod/chat/messages.php");
	var messages = elgg.getJSON(
		url,
		{
			success: function(data) {
				if (data.messages) {
					// Append messages to discussion
					$('.elgg-chat-messages > .elgg-list').append(data.messages);
				}
			}
		}
	);
}

elgg.register_hook_handler('ready', 'system', elgg.chat.ready);
