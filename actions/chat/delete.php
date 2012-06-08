<?php
/**
 * Delete chat entity
 *
 * @package Chat
 */

$chat_guid = get_input('guid');
$chat = get_entity($chat_guid);

if (elgg_instanceof($chat, 'object', 'chat') && $chat->canEdit()) {
	$container = get_entity($chat->container_guid);
	if ($chat->delete()) {
		system_message(elgg_echo('chat:message:deleted'));
		if (elgg_instanceof($container, 'group')) {
			forward("chat/group/$container->guid/all");
		} else {
			forward("chat/owner/$container->username");
		}
	} else {
		register_error(elgg_echo('chat:error:cannot_delete'));
	}
} else {
	register_error(elgg_echo('chat:error:post_not_found'));
}

forward(REFERER);