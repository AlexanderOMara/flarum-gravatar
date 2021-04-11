<?php

namespace AlexanderOMara\FlarumGravatar\Provider;

use Flarum\Foundation\AbstractServiceProvider;

use AlexanderOMara\FlarumGravatar\Core;

/**
 * CoreProvider functionality.
 */
class CoreProvider extends AbstractServiceProvider {
	/**
	 * Register method.
	 */
	public function register() {
		$this->container->singleton(Core::class);
	}
}
