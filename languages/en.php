<?php
/**
 * Chat English language file.
 */

$english = array(
	'chat' => 'Chat',
	'chat:chats' => 'Chats',
	'chat:view:all' => 'View all chats',
	'chat:chat' => 'Chat',
	'item:object:chat' => 'Chat',
	'item:object:chat_message' => 'Chat message',
	'chat:none' => 'No chats',
	'chat:more' => 'View more',

	'chat:title:user_chats' => '%s\'s chats',
	'chat:title:all_chats' => 'All site chats',
	'chat:title:friends' => 'Friends\' chats',
	'chat:messages' => 'Chat messages',
	'chat:members' => 'Add members',
	'chat:members:add' => 'Add members',
	'chat:leave' => 'Leave',
	'chat:leave:confirm' => 'Are you sure you want to permanently leave this chat? After leaving you cannot pariticipate in this chat anymore.',
	'chat:members:more' => "+%s others",
	'chat:unread_message' => '%s unread',
	'chat:unread_messages' => '%s unread', // Plurar

	'chat:group' => 'Group chat',
	'chat:enablechat' => 'Enable group chat',
	'chat:write' => 'Start a chat',
	'chat:message:send' => 'Send',

	// Editing
	'chat:add' => 'Start a chat',
	'chat:edit' => 'Edit chat',
	'chat:members:manage' => 'Add/remove members',
	'chat:delete:confirm' => 'Do you really want to remove this chat and all messages in it?',
	'chat:title' => 'Chat title',
	'chat:message' => 'Message',

	// messages
	'chat:message:saved' => 'Chat saved',
	'chat:message:deleted' => 'Chat deleted',
	'chat:message:chat_message:saved' => 'Message saved',
	'chat:message:chat_message:deleted' => 'Message deleted',
	'chat:message:members:saved' => 'Member added',
	'chat:message:members:saved:plurar' => '%s members added',
	'chat:message:left' => 'You have left the chat.',
	'chat:error:cannot_save' => 'Cannot start chat.',
	'chat:error:cannot_save_message' => 'Failed to save message.',
	'chat:error:cannot_write_to_container' => 'Insufficient access to start a chat in group.',
	'chat:error:cannot_add_member' => 'Failed to add user %s to chat.',
	'chat:error:cannot_delete' => 'Cannot delete chat.',
	'chat:error:missing:title' => 'Please enter title!',
	'chat:error:missing:members' => 'No members selected!',
	'chat:error:cannot_edit_post' => 'This chat may not exist or you may not have permissions to edit it.',
	'chat:error:cannot_leave' => 'Failed to leave chat.',

	// river
	'river:create:object:chat' => '%s started a chat %s',

	// user settings
	'chat:usersettings:emailnotification' => 'Send email notification when I receive a new message',

	// notifications
	'chat:notification:subject:newpost' => 'A new chat message',
	'chat:notification:newpost' =>
'
%s posted a new message to the chat "%s".

It says:

"%s"

View and send messages to the chat:
%s
',
	'chat:notification:subject:newchat' => 'A new chat',
	'chat:notification:newchat' =>
'
%s has added you to the chat "%s".

View and send messages to the chat:
%s
',

	// widget
	'chat:widget:description' => 'Display your latest chat messages',
	'chat:morechats' => 'More chats',
	'chat:numbertodisplay' => 'Number of chat messages to display',
	'chat:nochats' => 'No chat messages'
);

add_translation('en', $english);
