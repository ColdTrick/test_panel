<?php

$title = elgg_get_plugin_setting('message_title', 'test_panel');
$content = elgg_get_plugin_setting('message_content', 'test_panel');

// set correct HTTP header
elgg_set_http_header("HTTP/1.1 403 Forbidden");

// get system messages
$system_messages = _elgg_services()->systemMessages;
$messages = null;
if ($system_messages->count()) {
	$messages = $system_messages->dumpRegister();

	if (isset($messages['error'])) {
		// always make sure error is the first type
		$errors = [
			'error' => $messages['error']
		];

		unset($messages['error']);
		$messages = array_merge($errors, $messages);
	}
}

// draw content
$page_data = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
]);

// build custom sections
$sections = [
	'messages' => elgg_view('page/elements/messages', [
		'object' => $messages,
	]),
	'body' => elgg_view('page/elements/body', [
		'body' => $page_data,
	]),
	'footer' => elgg_view('page/elements/footer', $vars),
];

// draw page
echo elgg_view_page($title, $page_data, 'default', [
	'sections' => $sections,
]);
