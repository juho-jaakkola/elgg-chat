<?php
/**
 * Create an empty popup module to be populated via AJAX.
 */

$all_chats = elgg_view('output/url', array(
	'href' => 'chat/all',
	'text' => elgg_echo('chat:view:all'),
	'class' => '',
));

$add_chat = elgg_view('output/url', array(
	'href' => 'chat/add',
	'text' => elgg_echo('chat:add'),
	'class' => 'float-alt',
));

$links = "$all_chats $add_chat";

$vars = array(
	'class' => 'hidden elgg-chat-messages-preview',
	'id' => 'chat-messages-preview',
);

$title = elgg_echo('chat:chats');

$content = elgg_view_module('popup', $title, $links, $vars);

echo $content;