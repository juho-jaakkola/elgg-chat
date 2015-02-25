/**
 * Gets the unread chat messages via AJAX.
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	var ready = function() {
		// Get unread messages every 10 seconds
		setInterval(getUnreadMessages, 10000);

		// Mark unread messages read every two seconds
		// TODO Run this only when new messages have been added via XHR
		setInterval(markMessageRead, 2000);

		$('#chat-view-more').bind('click', pagination);
	};

	/**
	 * Get unread messages via AJAX.
	 */
	var getUnreadMessages = function() {
		var time_created = $('.elgg-chat-messages #timestamp').last().text();
		var guid = $('input:hidden[name=container_guid]').val();

		var url = elgg.normalize_url("chat/messages");
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

						// Scroll automatically to the bottom of the list
						var list = $(".elgg-chat-messages");
						list.animate({scrollTop: list[0].scrollHeight}, 1000);
					}
				}
			}
		);
	};

	/**
	 * Change the color of new messages.
	 */
	var markMessageRead = function() {
		var activeMessages = $('.elgg-chat-messages .elgg-chat-unread');
		var message = $(activeMessages[0]);
		message.animate({backgroundColor: '#ffffff'}, 1000).removeClass('elgg-chat-unread');
	};

	var pagination = function (event) {
		event.preventDefault();

		var guid = $('input:hidden[name=container_guid]').val();
		var time_created = $('.elgg-chat-messages #timestamp').first().text();
		var url = elgg.normalize_url("chat/messages");

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
	};

	elgg.register_hook_handler('init', 'system', ready);
});
