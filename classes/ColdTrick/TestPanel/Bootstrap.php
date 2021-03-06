<?php

namespace ColdTrick\TestPanel;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::boot()
	 */
	public function boot() {
		
		$this->validateAccess();
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		
		$this->registerHooks();
	}
	
	/**
	 * Register plugin hook handlers
	 *
	 * @return void
	 */
	protected function registerHooks() {
		$hooks = $this->elgg()->hooks;
		
		$hooks->registerHandler('setting', 'plugin', __NAMESPACE__ . '\PluginSettings::convertArrayToString');
		$hooks->registerHandler('validate', 'system:email', __NAMESPACE__ . '\EmailHandler::validate');
	}
	
	/**
	 * Validate access
	 *
	 * @return void
	 */
	protected function validateAccess() {
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user) || $user->isAdmin()) {
			// no user or admin user
			return;
		}
		
		$response = _elgg_services()->responseFactory;
		if ($response->isAction()) {
			// actions aren't proteced
			return;
		}
		
		$group_guids = test_panel_get_group_guids();
		if (!empty($group_guids)) {
			$group_membership_count = elgg_get_entities([
				'type' => 'group',
				'guids' => $group_guids,
				'count' => true,
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
