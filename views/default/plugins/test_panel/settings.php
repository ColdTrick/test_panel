<?php

/* @var $plugin ElggPlugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view('output/longtext', [
	'value' => elgg_echo('test_panel:settings:info'),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('test_panel:settings:group_guids'),
	'name' => 'params[group_guids]',
	'value' => $plugin->group_guids,
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('test_panel:settings:limit_notifications'),
	'#help' => elgg_echo('test_panel:settings:limit_notifications:description'),
	'name' => 'params[limit_notifications]',
	'checked' => $plugin->limit_notifications !== 'no',
	'default' => 'no',
	'value' => 'yes',
	'switch' => true,
]);

$title = elgg_echo('test_panel:settings:message');

$content = elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('test_panel:settings:message_title'),
	'name' => 'params[message_title]',
	'value' => $plugin->getSetting('message_title', elgg_echo('admin:legend:site_access')),
]);

$content .= elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('test_panel:settings:message_content'),
	'name' => 'params[message_content]',
	'value' => $plugin->getSetting('message_content', elgg_echo('limited_access')),
]);

echo elgg_view_module('info', $title, $content);
