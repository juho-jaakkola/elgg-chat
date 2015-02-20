<?php
/**
 * Chat German language file.
 */

$german = array(
	'chat' => 'Chat',
	'chat:chats' => 'Chats',
	'chat:view:all' => 'Zeige alle Chats',
	'chat:chat' => 'Chat',
	'item:object:chat' => 'Chat',
	'item:object:chat_message' => 'Chat-Nachricht',
	'chat:none' => 'Keine Chats',
	'chat:more' => 'Zeige mehr',

	'chat:title:user_chats' => '%s\'s Chats',
	'chat:title:all_chats' => 'Alle Seiten-Chats',
	'chat:title:friends' => 'Freunde Chats',
	'chat:messages' => 'Chat-Nachrichten',
	'chat:members' => 'Teilnehmer hinzufügen',
	'chat:members:add' => 'Teilnehmer hinzufügen',
	'chat:leave' => 'Verlassen',
	'chat:leave:confirm' => 'Bist Du sicher, dass Du diesen Chat dauerhaft verlassen willst? Nach dem Verlassen kannst Du an diesem Chat nicht mehr teilnehmen.',
	'chat:members:more' => "+%s andere",
	'chat:unread_message' => '%s ungelesen',
	'chat:unread_messages' => '%s ungelesen', // Plurar

	'chat:group' => 'Gruppen Chat',
	'chat:enablechat' => 'Ermögliche Gruppen Chat',
	'chat:write' => 'Starte einen Chat',
	'chat:message:send' => 'Senden',

	// Editing
	'chat:add' => 'Starte einen Chat',
	'chat:edit' => 'Bearbeite Chat',
	'chat:members:manage' => 'Teilnehmer hinzufügen/löschen',
	'chat:delete:confirm' => 'Willst Du wirklich diesen Chat und alle Nachrichten darin entfernen?',
	'chat:title' => 'Chat Titel',
	'chat:message' => 'Nachricht',

	// messages
	'chat:message:saved' => 'Chat gespeichert',
	'chat:message:deleted' => 'Chat gelöscht',
	'chat:message:chat_message:saved' => 'Nachricht gespeichert',
	'chat:message:chat_message:deleted' => 'Nachricht gelöscht',
	'chat:message:members:saved' => 'Teilnehmer hinzugefügt',
	'chat:message:members:saved:plurar' => '%s Teinehmer hinzugefügt',
	'chat:message:left' => 'Du hast den Chat verlassen.',
	'chat:error:cannot_save' => 'Chat kann nicht gestartet werden.',
	'chat:error:cannot_save_message' => 'Nachricht konnte nicht gespeichert werden.',
	'chat:error:cannot_write_to_container' => 'Unzureichender Zugang um eine Gruppen-Chat zu starten.',
	'chat:error:cannot_add_member' => 'Fehler beim Hinzufügen des Benutzers %s zum Chat.',
	'chat:error:cannot_delete' => 'Chat kann nicht gelöscht werden.',
	'chat:error:missing:title' => 'Bitte gebe einen Titel an!',
	'chat:error:missing:members' => 'Keine Teilnehmer ausgewählt!',
	'chat:error:cannot_edit_post' => 'Dieser Chat ist möglicherweise nicht vorhanden, oder Sie haben keine Berechtigung, diesen zu bearbeiten.',
	'chat:error:cannot_leave' => 'Fehler beim Verlassen des Chats',

	// river
	'river:create:object:chat' => '%s startete den Chat %s',

	// user settings
	'chat:usersettings:emailnotification' => 'Eine E-Mail-Benachrichtigung senden, wenn ich eine neue Nachricht erhalte.',

	// notifications
	'chat:notification:subject:newpost' => 'Eine neue Chatnachricht',
	'chat:notification:newpost' =>
'
%s schrieb eine neue Nachricht im Chat "%s".

Sie heißt:

"%s"

Nachrichten im Chat anzeigen und senden:
%s
',
	'chat:notification:subject:newchat' => 'Ein neuer Chat',
	'chat:notification:newchat' =>
'
%s hat dich zum Chat "%s" hinzugefügt.

Nachrichten im Chat anzeigen und senden:
%s
',

	// widget
	'chat:widget:description' => 'Deine aktuellen Chat-Nachrichten anzeigen',
	'chat:morechats' => 'Weitere Chats',
	'chat:numbertodisplay' => 'Anzahl der anzuzeigenden Chat-Nachrichten',
	'chat:nochats' => 'Keine Chat-Nachrichten'
);

add_translation('de', $german);
