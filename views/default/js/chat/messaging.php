<?php
/**
 * Gets the unread chat messages via AJAX.
 */
?>
/* <script> */

elgg.chat.ready = function() {
	// Get unread messages every 10 seconds
	setInterval(elgg.chat.getUnreadMessages, 10000);

	// Mark unread messages read every two seconds
	// TODO Run this only when new messages have been added via XHR
	setInterval(elgg.chat.markMessageRead, 2000);

	$('#chat-view-more').bind('click', elgg.chat.pagination);
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

/**
 * Change the color of new messages.
 */
elgg.chat.markMessageRead = function() {
	var activeMessages = $('.elgg-chat-messages .elgg-chat-unread');
	var message = $(activeMessages[0]);
	message.animate({backgroundColor: '#ffffff'}, 1000).removeClass('elgg-chat-unread');
};

elgg.chat.pagination = function (event) {
	event.preventDefault();

	var guid = $('input:hidden[name=container_guid]').val();
	var time_created = $('.elgg-chat-messages #timestamp').first().text();
	var url = elgg.normalize_url("mod/chat/messages.php");

	var params = {
		"guid": guid,
		"time_created": time_created,
		"pagination": true,
	};

	var messages = elgg.get(
		url,
		{
			data: params,
			success: function(data) {
				if (data) {
					var data = "<div class=\"hidden pagination\">" + data + "</div>";

					// Hide "more" link if we got less results than expected
					var count = $('li.elgg-item', data).length;
					if (count < 6) {
						$('#chat-view-more').hide();
					}

					$('.elgg-chat-messages > .elgg-list').prepend(data);
					$('.pagination').first().show('highlight', null, 2000);
				} else {
					$('#chat-view-more').hide();
				}
			}
		}
	);
}

elgg.register_hook_handler('init', 'system', elgg.chat.ready);
