<?php
require_once __DIR__ . "/lib/functions.php";

return [
	'plugin' => [
		'name' => 'IP Tracker',
		'version' => '4.0',
		'dependencies' => [],
	],
	'bootstrap' => IPTracker::class,
	'routes' => [
		'default:object:tracker' => [
			'path' => '/tracker/{ip}',
			'resource' => 'tracker/tracker',
		],
	],
];
