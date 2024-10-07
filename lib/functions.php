<?php

// Function to save IP address on login
function tracker_log_ip(\Elgg\Event $event) {
	$object = $event->getObject();

	if (($object) && ($object instanceof ElggUser)) {
		// Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) {
			$ip_address = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip_address = $forward;
    } else {
			$ip_address = $remote;
    }
		
		if (!empty($ip_address)) {
			$object->setMetadata('ip_address', $ip_address);
		}
	}

	return true;
}

// Add to the user hover admin menu
function tracker_admin_hover_menu(\Elgg\Event $event) {
	$params = $event->getParams();
	$return = $event->getValue();

	$user = $params['entity'];
	// Get IP address
	$ip_address = $user->ip_address;

	$return['tracker'] = \ElggMenuItem::factory([
			'name' => 'tracker',
			'icon' => 'sync-alt',
			'text' => elgg_echo('tracker:adminlink'),
			'href' => elgg_get_site_url(). "tracker/{$ip_address}",
			'section' => 'admin',
		]);

	return $return;
}