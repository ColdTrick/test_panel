<?php

use ColdTrick\TestPanel\Bootstrap;

require_once(__DIR__ . '/lib/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'limit_notifications' => 'yes',
		'message_title' => elgg_echo('admin:legend:site_access'),
		'message_content' => elgg_echo('limited_access'),
	],
];
