<?php

$plugin = elgg_extract('entity', $vars);

$yesno_options = [
	'yes' => elgg_echo('option:yes'),
	'no' => elgg_echo('option:no'),
];

echo elgg_format_element('div', [], elgg_echo('test_panel:settings:info'));

echo '<div>';
echo elgg_format_element('label', [], elgg_echo('test_panel:settings:group_guids'));
echo elgg_view('input/text', [
	'name' => 'params[group_guids]',
	'value' => $plugin->group_guids,
]);
echo '</div>';

echo '<div>';
echo elgg_format_element('label', [], elgg_echo('test_panel:settings:limit_notifications'));
echo elgg_view('input/select', [
	'name' => 'params[limit_notifications]',
	'value' => $plugin->limit_notifications,
	'options_values' => $yesno_options,
	'class' => 'mls',
]);
echo elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('test_panel:settings:limit_notifications:description'));
echo '</div>';

$title = elgg_echo('test_panel:settings:message');

$content = '<div class="mbm">';
$content .= elgg_format_element('label', [], elgg_echo('test_panel:settings:message_title'));
$content .= elgg_view('input/text', [
	'name' => 'params[message_title]',
	'value' => $plugin->message_title,
]);
$content .= '</div>';

$content .= '<div>';
$content .= elgg_format_element('label', [], elgg_echo('test_panel:settings:message_content'));
$content .= elgg_view('input/longtext', [
	'name' => 'params[message_content]',
	'value' => $plugin->message_content,
]);
$content .= '</div>';

echo elgg_view_module('inline', $title, $content);
