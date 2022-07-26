<?php
/**
 * All helper functions are bundled here
 */

use Elgg\Database\Select;

/**
 * Get the configured group guids
 *
 * @return array
 */
function test_panel_get_group_guids() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = [];
	
	$setting = (string) elgg_get_plugin_setting('group_guids', 'test_panel');
	if (!empty($setting)) {
		$result = elgg_string_to_array($setting);
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
	
	if (isset($result)) {
		return $result;
	}
	
	$result = [];
	
	$select = Select::fromTable('metadata', 'md');
	$select->select('md.value');
	$select->joinEntitiesTable('md', 'entity_guid', 'inner', 'e');
	$select->joinMetadataTable('e', 'guid', null, 'inner', 'mda');
	$select->andWhere($select->compare('e.type', '=', 'user', ELGG_VALUE_STRING));
	$select->andWhere($select->compare('md.name', '=', 'email', ELGG_VALUE_STRING));
	
	// admins
	$ands = $select->merge([
		$select->compare('mda.name', '=', 'admin', ELGG_VALUE_STRING),
		$select->compare('mda.value', '=', 'yes', ELGG_VALUE_STRING),
	]);
	
	// or group member
	$group_guids = test_panel_get_group_guids();
	if (!empty($group_guids)) {
		$group_members = $select->subquery('entity_relationships');
		$group_members->select('guid_one')
			->where($select->compare('relationship', '=', 'member', ELGG_VALUE_STRING))
			->andWhere($select->compare('guid_two', 'in', $group_guids, ELGG_VALUE_GUID));
		
		$or = $select->compare('md.entity_guid', 'in', $group_members->getSQL());
		
		$ands = $select->merge([$ands, $or], 'OR');
	}
	
	$select->andWhere($ands);
	
	$data = elgg()->db->getData($select);
	foreach ($data as $row) {
		$result[] = $row->value;
	}
	
	return $result;
}
