<?php

namespace ColdTrick\TestPanel;

use Psr\Log\LogLevel;

/**
 * Email system handler
 */
class EmailHandler {
	
	/**
	 * Prevent outgoing e-mail to non-test panel members
	 *
	 * @param \Elgg\Event $event 'validate' 'system:email'
	 *
	 * @return null|bool
	 */
	public static function validate(\Elgg\Event $event): ?bool {
		if (!$event->getValue()) {
			// someone else already blocked this e-mail
			return null;
		}
		
		if (elgg_get_plugin_setting('limit_notifications', 'test_panel') === 'no') {
			// don't limit e-mails
			return null;
		}
		
		$email = $event->getParam('email');
		if (!$email instanceof \Elgg\Email) {
			return null;
		}
		
		$to = $email->getTo();
		$cc = $email->getCc();
		$bcc = $email->getBcc();
		
		$recipients = array_merge($to, $cc, $bcc);
		if (empty($recipients)) {
			return null;
		}
		
		$allowed_emails = test_panel_get_panel_members_email_addresses();
		if (empty($allowed_emails)) {
			// nobody is allowed (shouldn't happen)
			return false;
		}
		
		foreach ($recipients as $recipient) {
			if (!$recipient instanceof \Elgg\Email\Address) {
				continue;
			}
			
			$to = $recipient->getEmail();
			elgg_log("Test panel processing: {$to}", LogLevel::INFO);
			
			if (!in_array($to, $allowed_emails)) {
				// user is not allowed to get e-mails
				elgg_log("Test panel blocked: {$to}", 'NOTICE');
				return false;
			}
		}
		
		return null;
	}
}
