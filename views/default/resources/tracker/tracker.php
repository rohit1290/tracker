<?php
// Restrict this page to admins only
elgg_admin_gatekeeper();

// Get IP
$ip = elgg_extract('ip', $vars);
if (empty($ip)) {
	$ip = get_input('ip');
}

// Set title
$title = elgg_echo('tracker:title', [$ip]);

// Get the list of all IP's
$content = elgg_list_entities([
	'metadata_name' => 'ip_address',
	'metadata_value' => $ip,
	'type' => 'user',
	'limit' => 25
]);

if (empty($content)) {
	$content = elgg_echo('tracker:ip_unused');
}

// Search box for the sidebar
set_input( 'ip', $ip );
$sidebar = elgg_view_module('aside',
	elgg_echo("search"),
	elgg_view_form('tracker/search', ['action' => elgg_get_site_url()."tracker"], [
		'ip' => $ip,
	])
);

// Tracker button (only if IP exists)
if ($ip) {
	$sidebar .= elgg_view('output/url', [
		'href' => sprintf(elgg_get_plugin_setting('tracker_url', 'tracker'), $ip),
		'text' => elgg_echo('tracker:search:info'),
		'target' => '_blank',
		'class' => 'elgg-button elgg-button-action mtl',
	]);
}

$body = elgg_view_layout('default', [
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
]);

echo elgg_view_page($title, $body);