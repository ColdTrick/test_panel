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
	public static function email($hook, $type, $returnvalue, $params) {
		
		if (empty($returnvalue) || !is_array($returnvalue)) {
			// someone else already send the emails
			return;
		}
		
		if (!test_panel_limit_notifications()) {
			// don't limit e-mails
			return;
		}
		
		$to = elgg_extract('to', $returnvalue);
		if (empty($to) || !is_string($to)) {
			// don't know how to handle this
			return;
		}
		
		$to = EmailHandler::sanitizeEmail($to);
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
	
	/**
	 * Strip out the name and leave only e-mail
	 *
	 * @param string $email the e-mail address to sanitize
	 *
	 * @return string
	 */
	public static function sanitizeEmail($email) {
		
		if (empty($email) || !is_string($email)) {
			return $email;
		}
		
		// email address in format: some name<somename@domain.ext>
		if (strpos($email, '<')) {
			$matches = [];
			
			preg_match('/<(.*)>/', $email, $matches);
			$email = $matches[1];
		}
		
		return trim($email);
	}
}
