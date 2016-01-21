<?php

$title = elgg_get_plugin_setting('message_title', 'test_panel', elgg_echo('admin:legend:site_access'));
$content = elgg_get_plugin_setting('message_content', 'test_panel', elgg_echo('limited_access'));

// build page elements
$head = elgg_view('page/elements/head');

$body = '<div class="elgg-page elgg-page-default elgg-page-test-panel">';
$body .= '<div class="elgg-page-body">';
$body .= '<div class="elgg-inner pvl">';
$body .= elgg_view_title($title);
$body .= elgg_view('output/longtext', [
	'value' => $content,
]);
$body .= '</div>';
$body .= '</div>';
$body .= '</div>';
$body .= elgg_view('page/elements/foot');

echo elgg_view('page/elements/html', [
	'head' => $head,
	'body' => $body,
]);
