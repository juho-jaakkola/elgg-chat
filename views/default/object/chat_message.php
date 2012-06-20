<?php
/**
 * View for chat message objects
 *
 * @package Chat
 */

$entity = elgg_extract('entity', $vars);

$owner = $entity->getOwnerEntity();
$owner_name = $owner->name;
$date = elgg_view_friendly_time($entity->time_created);

$user = elgg_get_logged_in_user_entity();
$not_read = elgg_get_annotations(array(
	'annotation_name' => 'unread',
	'annotation_owner_guids' => array($user->getGUID()),
	'guid' => $entity->getGUID(),
));

$time_created = "<span id=\"timestamp\" class=\"hidden\">$entity->time_created</span>";

$subtitle = "$owner_name $date $time_created";

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'entity',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$params = array(
	'entity' => $entity,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'content' => $entity->description,
);
$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);

$owner_icon = elgg_view_entity_icon($owner, 'small');

if ($not_read) {
	// Additional class to notify that message hasn't been read before.
	$vars['class'] = 'elgg-chat-unread';
	
	// Delete annotation
	$not_read[0]->delete();
}

if ($entity->canEdit()) {
	$body_vars = chat_prepare_message_form_vars($entity);
	$form_vars = array(
		'class' => 'hidden',
		'id' => "chat-edit-message-{$entity->getGUID()}",
	);
	$list_body .= elgg_view_form('chat/message/save', $form_vars, $body_vars);
}

echo elgg_view_image_block($owner_icon, $list_body, $vars);
