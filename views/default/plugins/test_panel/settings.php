<?php

$plugin = $vars["entity"];

echo "<div>";
echo elgg_echo("test_panel:settings:info");
echo "</div>";

echo "<div>";
echo "<label>" . elgg_echo("test_panel:settings:group_guids") . "</label>";
echo elgg_view("input/text", array(
	"name" => "params[group_guids]",
	"value" => $plugin->group_guids,
));
echo "</div>";

echo "<div>";
echo "<label>" . elgg_echo("test_panel:settings:message_title") . "</label>";
echo elgg_view("input/text", array(
	"name" => "params[message_title]",
	"value" => $plugin->message_title,
));
echo "</div>";

echo "<div>";
echo "<label>" . elgg_echo("test_panel:settings:message_content") . "</label>";
echo elgg_view("input/longtext", array(
	"name" => "params[message_content]",
	"value" => $plugin->message_content,
));
echo "</div>";