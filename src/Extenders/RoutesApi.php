<?php

namespace AlexanderOMara\FlarumGravatar\Extenders;

use Flarum\Extend\Routes;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

use AlexanderOMara\FlarumGravatar\Core;

/**
 * RoutesApi class.
 */
class RoutesApi extends Routes {
	/**
	 * RoutesApi class.
	 */
	public function __construct() {
		parent::__construct('api');
	}

	/**
	 * Extend method.
	 *
	 * @param Container $container Container object.
	 * @param Extension|null $extension Extension object.
	 */
	public function extend(Container $container, Extension $extension = null) {
		$core = $container->make(Core::class);

		// If local avatars disabled, do not allow upload.
		if ($core->settingDisableLocal()) {
			$this->remove('POST', 'users.avatar.upload');
		}

		return parent::extend($container, $extension);
	}
}
