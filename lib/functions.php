<?php
/**
 * All helper functions are bundled here
 */

/**
 * Limit outgoing e-mail to test panel members
 *
 * @return bool
 */
function test_panel_limit_notifications() {
	static $result;
	
	if (!isset($result)) {
		$result = true;
		
		$setting = elgg_get_plugin_setting('limit_notifications', 'test_panel');
		if ($setting === 'no') {
			$result = false;
		}
	}
	
	return $result;
}

/**
 * Get the configured group guids
 *
 * @return array
 */
function test_panel_get_group_guids() {
	static $result;
	
	if (!isset($result)) {
		$result = array();
		
		$setting = elgg_get_plugin_setting('group_guids', 'test_panel');
		if (!empty($setting)) {
			$result = string_to_tag_array($setting);
		}
	}
	
	return $result;
}

/**
 * Get all the email addresses of all test panel members (and admins)
 *
 * @return string[]
 */
function test_panel_get_panel_members_email_addresses() {
	static $result;
	
	if (!isset($result)) {
		$result = array();
		
		$dbprefix = elgg_get_config('dbprefix');
		
		$group_guids = test_panel_get_group_guids();
		$groups_where = '';
		if (!empty($group_guids)) {
			$groups_where = " OR guid IN (SELECT guid_one
				FROM {$dbprefix}entity_relationships
				WHERE relationship = 'member'
				AND guid_two IN (" . implode(',', $group_guids) . ")
				)";
		}
		
		$query = "SELECT email
			FROM {$dbprefix}users_entity
			WHERE admin = 'yes'
			{$groups_where}
			";
		
		$data = get_data($query);
		if (!empty($data)) {
			foreach ($data as $row) {
				$result[] = $row->email;
			}
		}
	}
	
	return $result;
}
