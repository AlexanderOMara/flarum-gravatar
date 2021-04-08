<?php

use Flarum\Extend;

use AlexanderOMara\FlarumGravatar\Extenders;
use AlexanderOMara\FlarumGravatar\Listener;

return [
	// Client-side code.
	(new Extend\Frontend('forum'))
		->js(__DIR__ . '/js/dist/forum.js')
		->content(Listener\AddData::class),
	(new Extend\Frontend('admin'))
		->js(__DIR__ . '/js/dist/admin.js')
		->content(Listener\AddData::class),

	// Extenders.
	new Extenders\BasicUserSerializing(),
	new Extenders\RoutesApi()
];
