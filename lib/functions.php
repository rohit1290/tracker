<?php

// Function to save IP address on login
function tracker_log_ip(\Elgg\Event $event) {
	$object = $event->getObject();

	if (($object) && ($object instanceof ElggUser)) {
		// Try to get IP address
		if (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
			// Check for multiple IP addresses in result from
			// HTTP_X_FORWARDED_FOR and return only the last one
			if (($pos = strrpos($ip_address, ",")) !== false) {
				$ip_address = substr($ip_address, $pos+1);
			}
		} elseif (getenv('HTTP_X_FORWARDED')) {
			$ip_address = getenv('HTTP_X_FORWARDED');
		} elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_FORWARDED_FOR');
		} elseif (getenv('HTTP_FORWARDED')) {
			$ip_address = getenv('HTTP_FORWARDED');
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		// Check for multiple IP addresses in
		if (($pos = strrpos($ip_address, ",")) !== false) {
			$ip_address = substr($ip_address, $pos+1);
		}

		if (!empty($ip_address)) {
			// create_metadata($object->guid, , 'text', $object->guid);
			$object->setMetadata('ip_address', $ip_address);
		}
	}

	return true;
}

// Add to the user hover admin menu
function tracker_admin_hover_menu(\Elgg\Hook $hook) {
	$params = $hook->getParams();
	$return = $hook->getValue();

	$user = $params['entity'];
	// Get IP address
	$ip_address = $user->ip_address;

	$url = elgg_get_site_url() . "tracker/{$ip_address}";
	$text = elgg_echo('tracker:adminlink');
	$item = new ElggMenuItem('tracker', $text, $url);
	$item->setSection('admin');
	$return[] = $item;

	return $return;
}