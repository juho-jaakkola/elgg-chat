<?php
/**
 * Saves user-specific plugin settings.
 *
 * @package Chat
 */

$email_notification = get_input('email_notification');
$plugin_id = get_input('plugin_id');
$user_guid = get_input('user_guid', elgg_get_logged_in_user_guid());
$plugin = elgg_get_plugin_from_id($plugin_id);
$user = get_entity($user_guid);

if (!($plugin instanceof ElggPlugin)) {
	register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_id)));
	forward(REFERER);
}

if (!($user instanceof ElggUser)) {
	register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_id)));
	forward(REFERER);
}

$plugin_name = $plugin->getManifest()->getName();

// make sure we're admin or the user
if (!$user->canEdit()) {
	register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_name)));
	forward(REFERER);
}

// Save
if (isset($email_notification[1])) {
	$result = $plugin->setUserSetting('email_notification', $email_notification[1], $user->guid);

	if (!$result) {
		register_error(elgg_echo('plugins:usersettings:save:fail', array($plugin_name)));
		forward(REFERER);
	}
} else {
	$plugin->unsetUserSetting('email_notification', $user->guid);
}

system_message(elgg_echo('plugins:usersettings:save:ok', array($plugin_name)));
forward(REFERER);
