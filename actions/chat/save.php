<?php
/**
 * Save chat entity
 *
 * @package Chat
 */

$guid = get_input('guid');
$title = get_input('title');
$description = get_input('message');
$members = get_input('members');

elgg_make_sticky_form('chat');

if (empty($title)) {
	register_error(elgg_echo("chat:error:missing:title"));
	forward(REFERER);
}

if (empty($members)) {
	register_error(elgg_echo("chat:error:missing:members"));
	forward(REFERER);
}

if ($guid) {
	$entity = get_entity($guid);
	
	if (elgg_instanceof($entity, 'object', 'chat') && $entity->canEdit()) {
		// Everything ok
	} else {
		register_error(elgg_echo('chat:error:chat_not_found'));
		forward(REFERER);
	}
} else {
	$entity = new ElggChat();
	$entity->subtype = 'chat';
	$entity->access_id = ACCESS_LOGGED_IN;
}

$entity->title = $title;

if ($entity->save()) {
	elgg_clear_sticky_form('chat');
} else {
	register_error(elgg_echo('chat:error:cannot_save'));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

// Add user itself if missing
if (!in_array($user->getGUID(), $members)){
	$members[] = $user->getGUID();
}

// Clear all current members because we don't know which ones were deleted.
$entity->deleteMembers();

// Add selected users to the chat
foreach ($members as $member_guid) {
	// Add relationship "user is a member of this chat".
	if (!$entity->addMember($member_guid)) {
		$member = get_entity($member_guid);
		register_error(elgg_echo("chat:error:cannot_add_member", array($member->name)));
	}
}

// Save the first chat message
if ($description) {
	$message = new ElggObject();
	$message->subtype = 'chat_message';
	$message->access_id = ACCESS_LOGGED_IN;
	$message->container_guid = $entity->getGUID();
	$message->description = $description;
	
	if ($message->save()) {
		$members = $entity->getMemberEntities();
		foreach ($members as $member) {
			// No unread annotation for user's own message
			if ($member->getGUID() === $user->getGUID()) {
				continue;
			}
			
			// annotate($name, $value, $access_id = ACCESS_PRIVATE, $owner_id = 0, $vartype = "")
			$message->annotate('unread', 1, ACCESS_PRIVATE, $member->getGUID());
			
			// Add number of unread messages also to the chat object
			$entity->increaseUnreadMessageCount($member);
		}
	} else {
		register_error(elgg_echo('chat:error:cannot_save_message'));
		forward($entity->getURL());
	}
}

system_message(elgg_echo('chat:message:saved'));
forward($entity->getURL());
