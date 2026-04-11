<?php
echo elgg_view_field([
	'#type' => 'text',
	'name' => "params[tracker_url]",
	'value' => $vars['entity']->tracker_url,
	'#label' => elgg_echo('tracker:url'),
	'#help' => elgg_echo('tracker:url:help'),
]);