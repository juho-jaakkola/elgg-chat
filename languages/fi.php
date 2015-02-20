<?php
/**
 * Chat Finnish language file.
 */

$finnish = array(
	'chat' => 'Chat',
	'chat:chats' => 'Chatit',
	'chat:view:all' => 'Näytä kaikki',
	'chat:chat' => 'Chat',
	'item:object:chat' => 'Chat',
	'item:object:chat_message' => 'Chat-viesti',
	'chat:none' => 'Ei chatteja',
	'chat:more' => 'Näytä aikaisemmat viestit',

	'chat:title:user_chats' => 'käyttäjän %s chatit',
	'chat:title:all_chats' => 'Kaikki chatit',
	'chat:title:friends' => 'Ystävien chatit',
	'chat:messages' => 'Chat-viestit',
	'chat:members' => 'Lisää ihmisiä chattiin',
	'chat:members:add' => 'Lisää ihmisiä',
	'chat:leave' => 'Poistu',
	'chat:leave:confirm' => 'Haluatko varmasti poistua lopullisesti tästä chatista? Poistumisen jälkeen et voi enää osallistua tähän keskusteluun.',
	'chat:members:more' => "+%s muuta",
	'chat:unread_message' => '%s lukematon',
	'chat:unread_messages' => '%s lukematonta', // Plural

	'chat:group' => 'Ryhmän chat',
	'chat:enablechat' => 'Ota käyttöön ryhmän chat',
	'chat:write' => 'Aloita uusi chat',
	'chat:message:send' => 'Lähetä',

	// Editing
	'chat:add' => 'Aloita uusi chat',
	'chat:edit' => 'Muokkaa',
	'chat:members:manage' => 'Lisää/Poista osallistujia',
	'chat:delete:confirm' => 'Haluatko varmasti poistaa tämän chatin ja kaikki siinä olevat viestit?',
	'chat:title' => 'Aihe',
	'chat:message' => 'Viesti',

	// messages
	'chat:message:saved' => 'Chat tallenettu',
	'chat:message:deleted' => 'Chat poistettu',
	'chat:message:chat_message:saved' => 'Viesti lisätty',
	'chat:message:chat_message:deleted' => 'Viesti poistettu',
	'chat:message:members:saved' => 'Lisättiin uusi osallistuja',
	'chat:message:members:saved:plurar' => 'Lisättiin %s uutta osallistujaa',
	'chat:message:left' => 'Olet poistunut chatista.',
	'chat:error:cannot_save' => 'Chatin aloittaminen epäonnistui.',
	'chat:error:cannot_save_message' => 'Viestin lähettäminen epäonnistui.',
	'chat:error:cannot_write_to_container' => 'Sinulla ei ole oikeuksia aloittaa chattia tässä ryhmässä.',
	'chat:error:cannot_add_member' => 'Henkilön %s lisääminen epäonnistui.',
	'chat:error:cannot_delete' => 'Chatin poistaminen epäonnistui.',
	'chat:error:missing:title' => 'Syötä chatille aihe!',
	'chat:error:missing:members' => 'Valitse vähintään yksi henkilö!',
	'chat:error:cannot_edit_post' => 'Tämä chat on poistettu tai sinulla ei ole oikeuksia muokata sitä.',
	'chat:error:cannot_leave' => 'Chatista poistuminen epäonnistui.',

	// river
	'river:create:object:chat' => '%s aloitti chatin aiheella %s',

	// user settings
	'chat:usersettings:emailnotification' => 'Lähetä sähköpostiin ilmoitus, kun joku lähettää minulle uuden viestin',

	// notifications
	'chat:notification:subject:newpost' => 'Uusi chat-viesti',
	'chat:notification:newpost' =>
'
%s lähetti uuden viestin chattiin "%s".

"%s"

Osallistu keskusteluun osoitteessa:
%s
',
	'chat:notification:subject:newchat' => 'Uusi chat-keskustelu',
	'chat:notification:newchat' =>
'
%s lisäsi sinut chat-keskusteluun "%s".

Osallistu keskusteluun osoitteessa:
%s
',

	// widget
	'chat:widget:description' => 'Näytä viimeisimmät chat-viestisi',
	'chat:morechats' => 'Lisää chatteja',
	'chat:numbertodisplay' => 'Näytettävien kohteiden määrä',
	'chat:nochats' => 'Ei viestejä'
);

add_translation('fi', $finnish);
