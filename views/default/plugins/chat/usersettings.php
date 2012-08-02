<?php

$value = elgg_get_plugin_user_setting('email_notification', elgg_get_logged_in_user_guid(), 'chat');

$checked = $value == 'on' ? true : false;

$email_input = elgg_view('input/checkbox', array(
	'name' => 'email_notification[]',
	'value' => $value,
	'checked' => $checked,
));

$email_label = elgg_echo('chat:usersettings:emailnotification');

echo <<<FORM
<div>
	$email_input
	$email_label
</div>
FORM;
