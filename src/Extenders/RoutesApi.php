<?php

namespace AlexanderOMara\FlarumGravatar\Extenders;

use Flarum\Extend\Routes;
use Flarum\Extension\Extension;
use Flarum\Settings\SettingsRepositoryInterface;
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
		$settings = $container->make(SettingsRepositoryInterface::class);

		// If local avatars disabled, do not allow upload.
		if (Core::settingDisableLocal($settings)) {
			$this->remove('POST', 'users.avatar.upload');
		}

		return parent::extend($container, $extension);
	}
}
