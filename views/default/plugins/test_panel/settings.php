<?php

$plugin = $vars["entity"];

echo elgg_echo("title");
echo elgg_view("input/text", array(
	"name" => "params[message_title]",
	"value" => $plugin->message_title,
));

echo elgg_echo("description");
echo elgg_view("input/longtext", array(
	"name" => "params[message_content]",
	"value" => $plugin->message_content,
));