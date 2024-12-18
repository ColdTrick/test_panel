<?php

use ColdTrick\TestPanel\Bootstrap;

require_once(__DIR__ . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '7.0.1',
	],
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'limit_notifications' => 'yes',
	],
	'events' => [
		'setting' => [
			'plugin' => [
				'\ColdTrick\TestPanel\PluginSettings::convertArrayToString' => [],
			],
		],
		'validate' => [
			'system:email' => [
				'\ColdTrick\TestPanel\EmailHandler::validate' => [],
			],
		],
	],
];
