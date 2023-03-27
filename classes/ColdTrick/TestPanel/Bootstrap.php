<?php

namespace ColdTrick\TestPanel;

use Elgg\DefaultPluginBootstrap;

/**
 * Plugin bootstrap
 */
class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritdoc}
	 */
	public function boot() {
		$this->validateAccess();
	}
	
	/**
	 * Validate access
	 *
	 * @return void
	 */
	protected function validateAccess(): void {
		$user = elgg_get_logged_in_user_entity();
		if (!$user instanceof \ElggUser || $user->isAdmin()) {
			// no user or admin user
			return;
		}
		
		$response = _elgg_services()->responseFactory;
		if ($response->isAction()) {
			// actions aren't protected
			return;
		}
		
		$group_guids = test_panel_get_group_guids();
		if (!empty($group_guids)) {
			$group_membership_count = elgg_count_entities([
				'type' => 'group',
				'guids' => $group_guids,
				'relationship' => 'member',
				'relationship_guid' => $user->guid,
			]);
			
			if ($group_membership_count > 0) {
				return;
			}
		}
		
		$title = $this->plugin()->getSetting('message_title', elgg_echo('admin:legend:site_access'));
		$content = $this->plugin()->getSetting('message_content', elgg_echo('limited_access'));
		$content = elgg_view('output/longtext', [
			'value' => $content,
		]);
		
		elgg_set_viewtype('failsafe');
		
		$content = elgg_view_page($title, $content);
		$output = elgg_ok_response($content, '', '', ELGG_HTTP_FORBIDDEN);
		$response->respondWithError($output);
		exit(); // prevent the rest of the system to run
	}
}
