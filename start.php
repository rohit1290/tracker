<?php
/**
 * Elgg Tracker plugin
 * @license: GPL v 2.
 * @author slyhne
 * @copyright tiger-inc.eu
 * @link http://tiger-inc.eu
 */

elgg_register_event_handler('init','system','tracker_init');

function tracker_init() {

	// IP logging at create/login events
	elgg_register_event_handler('login:after', 'user', 'tracker_log_ip');
	elgg_register_event_handler('create', 'user', 'tracker_log_ip');

	// Show IP address on profile
	if (elgg_is_admin_logged_in()) {
		if (elgg_get_plugin_setting('tracker_display', 'tracker') == 'profile') {
			elgg_extend_view('profile/owner_block', 'tracker/profile_ip');
		} else {
			// Extend avatar hover menu
			elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'tracker_admin_hover_menu');
		}
	}
}

// Function to save IP address on login
function tracker_log_ip($event, $object_type, $object) {
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
function tracker_admin_hover_menu($hook, $type, $return, $params) {
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
