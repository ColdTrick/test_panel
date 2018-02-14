<?php
/**
 * Main test panel file
 */

require_once(dirname(__FILE__) . '/lib/functions.php');

// default elgg events
elgg_register_event_handler('init', 'system', 'test_panel_init');

/**
 * Called during system init
 */
function test_panel_init() {
	
	elgg_register_event_handler('ready', 'system', 'test_panel_ready');
	
	// plugin hooks
	elgg_register_plugin_hook_handler('validate', 'system:email', '\ColdTrick\TestPanel\EmailHandler::validate');
}

/**
 * Check access of the user on system,ready
 *
 * @return void
 */
function test_panel_ready() {
	$user = elgg_get_logged_in_user_entity();
	
	if (empty($user)) {
		return;
	}
	
	if (elgg_is_admin_logged_in()) {
		return;
	}
		
	$group_guids = test_panel_get_group_guids();
	if (!empty($group_guids)) {
		foreach ($group_guids as $group_guid) {
			
			$group = get_entity($group_guid);
			if (!($group instanceof ElggGroup)) {
				continue;
			}
			
			if ($group->isMember($user)) {
				return;
			}
		}
	}
	
	echo elgg_view('test_panel/wrapper');
	exit();
}
