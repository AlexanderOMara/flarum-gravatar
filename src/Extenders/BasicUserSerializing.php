<?php

namespace AlexanderOMara\FlarumGravatar\Extenders;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Container\Container;

use AlexanderOMara\FlarumGravatar\Core;

/**
 * BasicUserSerializing class.
 */
class BasicUserSerializing implements ExtenderInterface {
	/**
	 * Container object.
	 *
	 * @var Container|null
	 */
	protected /*?Container*/ $container = null;

	/**
	 * Extend method.
	 *
	 * @param Container $container Container object.
	 * @param Extension|null $extension Extension object.
	 */
	public function extend(
		Container $container,
		Extension $extension = null
	): void {
		$this->container = $container;

		$container->events->listen(Serializing::class, [$this, 'serializing']);
	}

	/**
	 * Serializing callback.
	 *
	 * @param Serializing $event Serializing event.
	 */
	public function serializing(Serializing $event): void {
		if (!$event->isSerializer(BasicUserSerializer::class)) {
			return;
		}

		// Replace the avatar URL.
		$key = 'avatarUrl';
		$event->attributes[$key] = Core::userAvatarUrl(
			$this->container->make(SettingsRepositoryInterface::class),
			$event->model,
			$event->attributes[$key]
		);
	}
}
