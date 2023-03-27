<?php

namespace ColdTrick\TestPanel;

/**
 * Plugin setting related events
 */
class PluginSettings {
	
	/**
	 * Convert arrays to a comma separated string so the plugin setting can be saved
	 *
	 * @param \Elgg\Event $event 'setting', 'plugin'
	 *
	 * @return null|string
	 */
	public static function convertArrayToString(\Elgg\Event $event): ?string {
		if ($event->getParam('plugin_id') !== 'test_panel') {
			// not correct plugin
			return null;
		}
		
		$value = $event->getValue();
		if (!is_array($value)) {
			// not an array
			return null;
		}
		
		$value = array_filter(array_unique($value));
		
		return implode(',', $value);
	}
}
