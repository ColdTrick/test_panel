<?php

namespace ColdTrick\TestPanel;

class EmailHandler {
	
	/**
	 * Prevent outgoing e-mail to non test panel members
	 *
	 * @param string $hook        the name of the hook
	 * @param string $type        the type of the hook
	 * @param array  $returnvalue the current return value
	 * @param array  $params      supplied params
	 *
	 * @return void|false
	 */
	public static function validate(\Elgg\Hook $hook) {
		
		if (!$hook->getValue()) {
			// someone else already blocked this e-mail
			return;
		}
		
		if (!test_panel_limit_notifications()) {
			// don't limit e-mails
			return;
		}
		
		$email = $hook->getParam('email');
		if (!$email instanceof \Elgg\Email) {
			return;
		}
		
		$recipient = $email->getTo();
		if (!$recipient instanceof \Elgg\Email\Address) {
			return;
		}
		
		$to = $recipient->getEmail();
		elgg_log("Test panel processing: {$to}", 'INFO');
		
		$allowed_emails = test_panel_get_panel_members_email_addresses();
		if (empty($allowed_emails) || !is_array($allowed_emails)) {
			// nobody is allowed (shouldn't happen)
			return false;
		}
		
		if (!in_array($to, $allowed_emails)) {
			// user is not allowed to get e-mails
			elgg_log("Test panel blocked: {$to}", 'NOTICE');
			return false;
		}
		
		// user is a panel member, so can receive e-mails
	}
}
