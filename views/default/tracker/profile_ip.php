<?php
// Restrict this page to admins only
elgg_admin_gatekeeper();

$owner_guid = $vars['entity']->guid;
$owner = get_user($owner_guid);
$ip_address = $owner->ip_address;
$info = "";

if (empty($ip_address)) {
	// Display error text
	$info .= elgg_echo('tracker:none:recorded');
} else {
	// Create info link
	// Get URL for IP information
	$info .= elgg_view('output/url', [
		'text' => elgg_echo('tracker:info'),
		'href' => sprintf(elgg_get_plugin_setting('tracker_url', 'tracker'), $ip_address),
		'is_trusted' => true,
		'target' => "_blank",
	]);
	
	// Create tracker link
	$info .= " | ";
	$info .= elgg_view('output/url', [
		'text' => $ip_address,
		'href' => "tracker/$ip_address",
		'is_trusted' => true,
	]);
	
	// Create log link
	if (elgg_is_active_plugin('logbrowser')) {
		$info .= " | ";
		$info .= elgg_view('output/url', [
			'text' => elgg_echo('logbrowser:explore'),
			'href' => elgg_http_add_url_query_elements('admin/administer_utilities/logbrowser', ['ip_address' => $ip_address]),
			'is_trusted' => true,
		]);
	}
}

// Display IP address
echo "<p><div class='even'><b>IP:</b> $info </div></p>";