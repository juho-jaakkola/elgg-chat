<?php
/**
 * Ajax endpoint for getting new chat messages.
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');

$user = elgg_get_logged_in_user_entity();

$messages = elgg_get_entities_from_annotations(array(
	'type' => 'object',
	'subtype' => 'chat_message',
	'annotation_name' => 'unread',
	'annotation_owner_guids' => $user->getGUID(),
	'order_by' => 'e.time_created asc',
	'limit' => false,
));

$html = '';
foreach ($messages as $message) {
	$id = "elgg-object-{$message->getGUID()}";
	$item = elgg_view_list_item($message, $vars);
	$html .= "<li id=\"$id\" class=\"elgg-item\">$item</li>";
}

$result = new stdClass();
$result->messages = $html;

echo json_encode($result);
