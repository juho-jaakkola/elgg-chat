<?php
/**
 * Create an empty popup module to be populated via AJAX.
 */

$add_chat_link = elgg_view('output/url', array(
	'href' => 'chat/add',
	'text' => elgg_echo('chat:add'),
	'class' => 'float-alt',
));

$vars = array(
	'class' => 'hidden elgg-chat-messages-preview',
	'id' => 'chat-messages-preview',
);

$title = elgg_echo('chat:chats');

$content = elgg_view_module('popup', $title, $add_chat_link, $vars);

echo $content;