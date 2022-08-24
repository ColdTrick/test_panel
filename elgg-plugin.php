<?php

use ColdTrick\TestPanel\Bootstrap;

require_once(__DIR__ . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '5.0',
	],
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'limit_notifications' => 'yes',
	],
	'hooks' => [
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
