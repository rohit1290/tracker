<?php

	admin_gatekeeper();

	// Get IP
	$ip = elgg_extract('ip',$vars);
	if (empty($ip)) {
		$ip = get_input('ip');
	}

	// Set title
	$title = elgg_echo('tracker:title', array($ip));

	// Get the list of all IP's
	$content = elgg_list_entities_from_metadata(array(
		'metadata_name' => 'ip_address',
		'metadata_value' => $ip,
		'type' => 'user',
		'limit' => 25
	));

	if (empty($content)) {
		$content = elgg_echo('tracker:ip_unused');
	}

	// Search box for the sidebar
	set_input( 'ip', $ip );
	$sidebar = elgg_view_module('aside',  elgg_echo("search"), elgg_view('tracker/search'));

	$body = elgg_view_layout('content', array(
		'filter' => '',
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
	));

	echo elgg_view_page($title, $body);

 ?>
