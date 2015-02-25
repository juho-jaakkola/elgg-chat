<?php
/**
 * Chat
 *
 * @package Chat
 */

/**
 * Initialize the plugin.
 */
function chat_init() {
	global $CONFIG;

	$actionspath = $CONFIG->pluginspath . "chat/actions/chat";
	elgg_register_action("chat/save", "$actionspath/save.php");
	elgg_register_action("chat/addmembers", "$actionspath/addmembers.php");
	elgg_register_action("chat/leave", "$actionspath/leave.php");
	elgg_register_action("chat/delete", "$actionspath/delete.php");
	elgg_register_action("chat/message/save", "$actionspath/message/save.php");
	elgg_register_action("chat/message/delete", "$actionspath/message/delete.php");
	elgg_register_action("chat/usersettings/save", "$actionspath/usersettings/save.php");

	$libpath = elgg_get_plugins_path() . 'chat/lib/chat.php';
	elgg_register_library('chat', $libpath);

	elgg_require_js('chat/chat');

	// Add custom CSS
	elgg_extend_view('css', 'chat/css');

	// Register on low priority so it's possible to remove items added by other plugins
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'chat_entity_menu_setup', 600);
	// Register on low priority so it's possible to remove items added by other plugins
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'chat_message_menu_setup', 600);
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'chat_permissions_override');
	elgg_register_plugin_hook_handler('entity:url', 'object', 'chat_url_handler');

	elgg_register_event_handler('pagesetup', 'system', 'chat_notifier');

	elgg_register_page_handler('chat', 'chat_page_handler');
}

/**
 * Dispatche chat pages.
 *
 * @param array $page
 * @return bool
 */
function chat_page_handler ($page) {
	elgg_load_library('chat');

	if (!isset($page[0])) {
		elgg_push_breadcrumb(elgg_echo('chat'));
		$page[0] = 'all';
	} else {
		elgg_push_breadcrumb(elgg_echo('chat'), 'chat/all');
	}

	switch ($page[0]) {
		case 'messages':
			include(__DIR__ . '/messages.php');
			return true;
		case 'notifier':
			include(__DIR__ . '/notifier.php');
			return true;
		case 'owner':
			$user = get_user_by_username($page[1]);
			$params = chat_all($user->guid);
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			$params = chat_friends($user->guid);
			break;
		case 'add':
			gatekeeper();
			$params = chat_edit();
			break;
		case 'edit':
			gatekeeper();
			$params = chat_edit($page[1]);
			break;
		case 'view':
			$params = chat_view($page[1]);
			break;
		case 'members':
			gatekeeper();
			$params = chat_add_members($page[1]);
			break;
		case 'all':
		default:
			$params = chat_all();
			break;
		}

	$body = elgg_view_layout('content', $params);
	echo elgg_view_page('test', $body);
	return true;
}

/**
 * Format and return the URL for chats.
 *
 * @param string $hook   'entity:url'
 * @param string $type   'object'
 * @param string $url    The current URL
 * @param array  $params Array('entity' => ElggObject)
 * @return string URL of the chat
 */
function chat_url_handler($hook, $type, $url, $params) {
	$entity = elgg_extract('entity', $params);

	if (!$entity instanceof ElggChat) {
		return $url;
	}

	$title = elgg_get_friendly_title($entity->title);

	return "chat/view/{$entity->guid}/$title";
}

/**
 * Add title button for adding more people to a chat.
 *
 * All members of the chat are allowed to add people.
 *
 * @todo Is it possible to use userpicker through lightbox?
 *
 * @param obj $entity ElggChat object
 */
function chat_register_addusers_button($entity) {
	if (elgg_is_logged_in()) {
		$user = elgg_get_logged_in_user_entity();

		if ($user && $entity->isMember()) {
			$guid = $entity->getGUID();
			elgg_register_menu_item('title', array(
				'name' => 'chat_members',
				'href' => "chat/members/$guid",
				'text' => elgg_echo('chat:members:add'),
				'link_class' => 'elgg-button elgg-button-action', // elgg-lightbox
			));
		}

		/*
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');

		elgg_load_js('elgg.userpicker');
		*/
	}
}

/**
 * Set up the entity menu for chat entities.
 */
function chat_entity_menu_setup ($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'chat') {
		return $return;
	}

	$num_messages = $entity->getUnreadMessagesCount();
	if ($num_messages) {
		if ($num_messages == 1) {
			$string = 'chat:unread_message'; // Singular
		} else {
			$string = 'chat:unread_messages'; // Plural
		}

		$text = elgg_echo($string, array($num_messages));

		$options = array(
			'name' => 'unread_mesages',
			'text' => $text,
			'href' => false,
			'priority' => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	// Use white list to prevent unwanted menu items
	$allow = array('unread_mesages');
	if (!elgg_in_context('chat_preview')) {
		$allow[] = 'edit';
		$allow[] = 'delete';
	}

	// Remove unwanted menu items
	foreach ($return as $index => $item) {
		if (!in_array($item->getName(), $allow)) {
			unset($return[$index]);
		}
	}

	return $return;
}

/**
 * Set up the entity menu for chat messages.
 */
function chat_message_menu_setup ($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];

	if ($entity->getSubtype() !== 'chat_message') {
		return $return;
	}

	// We don't want other plugins to add new menu items so we use a white list
	$allow = array('likes');

	$user = elgg_get_logged_in_user_entity();

	if ($entity->getOwnerGUID() == $user->getGUID() || $user->isAdmin()) {
		$guid = $entity->getGUID();

		$options = array(
			'name' => 'edit',
			'text' => elgg_echo('edit'),
			'href' => "#chat-edit-message-$guid",
			'priority' => 100,
			'rel' => 'toggle',
		);
		$return[] = ElggMenuItem::factory($options);

		$options = array(
			'name' => 'delete',
			'text' => elgg_view_icon('delete'),
			'href' => "action/chat/message/delete?guid=$guid",
			'priority' => 150,
			'is_action' => true,
		);
		$return[] = ElggMenuItem::factory($options);

		$allow[] = 'edit';
		$allow[] = 'delete';
	}

	// Remove unwanted menu items
	foreach ($return as $index => $item) {
		if (!in_array($item->getName(), $allow)) {
			unset($return[$index]);
		}
	}

	return $return;
}

/**
 * Display notification of new chat messages in topbar
 */
function chat_notifier() {
	if (elgg_is_logged_in()) {
		// Add hidden popup module to topbar
		elgg_extend_view('page/elements/topbar', 'chat/preview');

		$text = elgg_view_icon('speech-bubble-alt');

		$count = chat_count_unread_messages();
		if ($count) {
			$text .= "<span id=\"chat-messages-new\">$count</span>";
		} else {
			// Add a hidden element so value can be added using XHR
			$text .= "<span id=\"chat-messages-new\" class=\"hidden\"></span>";
		}

		// This link opens the popup module
		elgg_register_menu_item('topbar', array(
			'name' => 'chat-notifier',
			'href' => '#chat-messages-preview',
			'text' => $text,
			'priority' => 600,
			'title' => elgg_echo("chat:messages"),
			'rel' => 'popup',
			'id' => 'chat-preview-link',
		));
	}
}

/**
 * Get all chats with unread messages.
 *
 * @param array $options See elgg_get_entities_from_annotations().
 */
function chat_get_unread_chats($options = array()) {
	$user = elgg_get_logged_in_user_entity();

	$defaults = array(
		'type' => 'object',
		'subtype' => 'chat',
		'annotation_names' => 'unread_messages',
		'annotation_owner_guids' => $user->getGUID(),
		'count' => false,
	);

	$options = array_merge($defaults, $options);

	return elgg_get_entities_from_annotations($options);
}

/**
 * Get the number of all unread chat messages.
 *
 * @return mixed False on error, int if success.
 */
function chat_count_unread_messages() {
	$user_guid = elgg_get_logged_in_user_guid();

	return elgg_get_entities_from_relationship(array(
		'type' => 'object',
		'subtype' => 'chat_message',
		'count' => true,
		'relationship' => 'unread',
		'relationship_guid' => $user_guid,
		'inverse_relationship' => true,
	));
}

/**
 * Allow chat members to add messages to chat.
 */
function chat_permissions_override($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$user = $params['user'];

	if (elgg_instanceof($entity, 'object', 'chat')) {
		// Allow full access to administrators
		if ($user->isAdmin()) {
			return true;
		}

		// Allow chat members to add messages to chat
		if ($entity->isMember($user) && elgg_in_context('chat_message')) {
			return true;
		}
	}

	return $return;
}

elgg_register_event_handler('init', 'system', 'chat_init');
