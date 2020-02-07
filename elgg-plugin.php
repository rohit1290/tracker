<?php
require_once __DIR__ . "/lib/functions.php";

return [
	'bootstrap' => IPTracker::class,
	'routes' => [
		'default:object:tracker' => [
			'path' => '/tracker/{ip}',
			'resource' => 'tracker/tracker',
		],
	],
];
