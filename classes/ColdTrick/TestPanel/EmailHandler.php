<?php

namespace ColdTrick\TestPanel;

class EmailHandler {
	
	/**
	 * Prevent outgoing e-mail to non test panel members
	 *
	 * @param \Elgg\Hook $hook 'validate' 'system:email'
	 *
	 * @return void|false
	 */
	public static function validate(\Elgg\Hook $hook) {
		
		if (!$hook->getValue()) {
			// someone else already blocked this e-mail
			return;
		}
		
		if (elgg_get_plugin_setting('limit_notifications', 'test_panel') === 'no') {
			// don't limit e-mails
			return;
		}
		
		$email = $hook->getParam('email');
		if (!$email instanceof \Elgg\Email) {
			return;
		}
		
		$to = $email->getTo();
		$cc = $email->getCc();
		$bcc = $email->getBcc();
		
		$recipients = array_merge($to, $cc, $bcc);
		if (empty($recipients)) {
			return;
		}
		
		$allowed_emails = test_panel_get_panel_members_email_addresses();
		if (empty($allowed_emails) || !is_array($allowed_emails)) {
			// nobody is allowed (shouldn't happen)
			return false;
		}
		
		foreach ($recipients as $recipient) {
			if (!$recipient instanceof \Elgg\Email\Address) {
				continue;
			}
			
			$to = $recipient->getEmail();
			elgg_log("Test panel processing: {$to}", 'INFO');
			
			if (!in_array($to, $allowed_emails)) {
				// user is not allowed to get e-mails
				elgg_log("Test panel blocked: {$to}", 'NOTICE');
				return false;
			}
		}
	}
}
