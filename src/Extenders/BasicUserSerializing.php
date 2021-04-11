<?php

namespace AlexanderOMara\FlarumGravatar\Extenders;

use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Extend\ApiSerializer;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

use AlexanderOMara\FlarumGravatar\Core;

/**
 * BasicUserSerializing class.
 */
class BasicUserSerializing extends ApiSerializer {
	/**
	 * Core object.
	 *
	 * @var Core|null
	 */
	protected /*?Core*/ $core = null;

	/**
	 * BasicUserSerializing class.
	 */
	public function __construct() {
		parent::__construct(BasicUserSerializer::class);

		$this->attribute('avatarUrl', [$this, 'avatarUrl']);
	}

	/**
	 * Extend method.
	 *
	 * @param Container $container Container object.
	 * @param Extension|null $extension Extension object.
	 */
	public function extend(Container $container, Extension $extension = null) {
		$this->core = $container->make(Core::class);

		return parent::extend($container, $extension);
	}

	/**
	 * Attribute avatarUrl value callback.
	 *
	 * @param BasicUserSerializer $serializer Serializer object.
	 * @param mixed $model The model being serialized.
	 * @param array $attributes Current attributes.
	 */
	public function avatarUrl(
		BasicUserSerializer $serializer,
		$model,
		array $attributes
	) {
		return $this->core->userAvatarUrl(
			$model->email,
			$attributes['avatarUrl'] ?? $model->avatar_url
		);
	}
}
