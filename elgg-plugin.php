<?php
return [
	'plugin' => [
		'name' => 'IP Tracker',
		'version' => '7.0',
	],
	'settings' => [
		'tracker_url' => 'https://ipinfo.io/%s',
	],
	'routes' => [
		'default:object:tracker' => [
			'path' => '/tracker/{ip}',
			'resource' => 'tracker/tracker',
		],
	],
	'view_extensions' => [
		'profile/owner_block' => [
			'tracker/profile_ip' => [],
		]
	],
	'events' => [
		'login:after' => [
			'user' => [
				'\IPTracker::LogIP' => [],
			],
		],
		'create' => [
			'user' => [
				'\IPTracker::LogIP' => [],
			],
		],
		// 'register' => [
		// 	'menu:user_hover' => [
		// 		'\IPTracker::AdminHoverMenu' => [],
		// 	],
		// ],
	],
];