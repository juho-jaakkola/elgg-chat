<?php
/**
 * Chat CSS
 */
?>

/* ***************************************
	Chat
*************************************** */

/* Style the popup modules */
.elgg-chat-members,
#chat-messages-preview {
	width: 345px;
	position: absolute;
}

.elgg-chat-messages {
	max-height: 400px;
	overflow: auto;
}

.elgg-chat-unread {
	background: #EDF5FF;
}

/* Count of unread chat messages in the topbar */
#chat-messages-new {
	color: white;
	background-color: red;

	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;

	-webkit-box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.50);
	-moz-box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.50);
	box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.50);

	position: absolute;
	text-align: center;
	top: 0px;
	left: 26px;
	min-width: 16px;
	height: 16px;
	font-size: 10px;
	font-weight: bold;
}