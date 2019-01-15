<?php

use ColdTrick\TestPanel\Bootstrap;

require_once(__DIR__ . '/lib/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'limit_notifications' => 'yes',
	],
];
