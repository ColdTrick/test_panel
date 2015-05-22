<?php

$plugin = elgg_extract('entity', $vars);

$yesno_options = array(
	'yes' => elgg_echo('option:yes'),
	'no' => elgg_echo('option:no'),
);

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
echo "<label>" . elgg_echo("test_panel:settings:limit_notifications") . "</label>";
echo elgg_view("input/select", array(
	"name" => "params[limit_notifications]",
	"value" => $plugin->limit_notifications,
	"options_values" => $yesno_options,
	"class" => "mls"
));
echo "<div class='elgg-subtext'>" . elgg_echo('test_panel:settings:limit_notifications:description') . "</div>";
echo "</div>";

$title = elgg_echo('test_panel:settings:message');

$content = "<div class='mbm'>";
$content .=  "<label>" . elgg_echo("test_panel:settings:message_title") . "</label>";
$content .= elgg_view("input/text", array(
	"name" => "params[message_title]",
	"value" => $plugin->message_title,
));
$content .= "</div>";

$content .= "<div>";
$content .= "<label>" . elgg_echo("test_panel:settings:message_content") . "</label>";
$content .= elgg_view("input/longtext", array(
	"name" => "params[message_content]",
	"value" => $plugin->message_content,
));
$content .= "</div>";

echo elgg_view_module('inline', $title, $content);