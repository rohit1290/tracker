<?php

return [
	'routes' => [
		'default:object:tracker' => [
			'path' => '/tracker/{ip}',
			'resource' => 'tracker/tracker',
		],
	],
];
