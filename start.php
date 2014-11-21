<?php

/**
 * Init function for Test Panel
 *
 * @return void
 */
function test_panel_pagesetup() {
	$user = elgg_get_logged_in_user_entity();
	
	if (empty($user)) {
		return;
	}
	
	if (elgg_is_admin_logged_in()) {
		return;
	}
		
	$groups = elgg_get_plugin_setting("group_guids", "test_panel");
	if (!empty($groups)) {
		$groups = explode(",", $groups);
	
		foreach ($groups as $group_guid) {
			$group_guid = trim($group_guid);
	
			$group = get_entity($group_guid);
			if (!($group instanceof ElggGroup)) {
				continue;
			}
			if ($group->isMember($user)) {
				return;
			}
		}
	}
		
	echo elgg_view("test_panel/wrapper");
	exit();
}

elgg_register_event_handler("pagesetup", "system", "test_panel_pagesetup");
