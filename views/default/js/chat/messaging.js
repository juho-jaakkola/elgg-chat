/**
 * Gets the unread chat messages via AJAX.
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	var messages = $('.elgg-chat-messages');

	/**
	 * Initialize the module
	 */
	var ready = function() {
		goToBottom();

		messages.scroll(markMessagesRead);

		// Get unread messages every 10 seconds
		setInterval(getUnreadMessages, 10000);

		$('#chat-view-more').bind('click', pagination);
	};

	/**
	 * Mark messages read when they are fully visible in the chat window
	 *
	 * Removes the highlighted background color and removes the class
	 * that identifies the item as unread.
	 */
	var markMessagesRead = function() {
		var unread = $('.elgg-chat-unread');

		if (unread.length) {
			var unreadMessage = $(unread[0]);

			var unreadListItem = unreadMessage.parent();

			var unreadMessageTop = 0;

			// Count total height of all read messages
			unreadListItem.prevAll().each(function(k, v) {
				unreadMessageTop += $(v).outerHeight();
			});

			// Amount of pixels from top of the list to the bottom
			// of the first unread message.
			var unreadMessageBottom = unreadMessageTop + unreadListItem.outerHeight();

			// Check if the oldest unread message is fully inside the chat message window
			if ((unreadMessageBottom - messages.scrollTop()) <= messages.height()) {
				// Message is visible. Animate the background color away and
				// remove the class that identifies the message as unread.
				unreadMessage.animate({backgroundColor: '#ffffff'}, 1000).removeClass('elgg-chat-unread');

				updateUnreadMessageNotification();
			}
		}
	};

	/**
	 * Notifies user about new unread messages
	 *
	 * Either updates the amount of unread messages, or hides the
	 * notification completely in case there aren't any unread messages.
	 */
	var updateUnreadMessageNotification = function() {
		var notice = $('#elgg-chat-notice');
		var unreadCount = $('.elgg-chat-unread').length;

		if (unreadCount) {
			// Update the notification
			var noticeText = elgg.echo('chat:unread_messages', [unreadCount]);
			notice.html(noticeText).show();
		} else {
			// Hide the notification
			notice.hide();
		}
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

						// Notify user about new unread messages
						updateUnreadMessageNotification();
					}
				}
			}
		);
	};

	/**
	 * Scroll to the bottom of the chat message list
	 */
	var goToBottom = function() {
		var list = $(".elgg-chat-messages");
		var scrollHeight = list[0].scrollHeight;

		list.scrollTop(scrollHeight);
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
