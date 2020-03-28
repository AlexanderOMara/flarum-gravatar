<?php

namespace AlexanderOMara\FlarumGravatar\Listener;

use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

use AlexanderOMara\FlarumGravatar\Core;

/**
 * Data hook.
 */
class AddData {
	/**
	 * Settings object.
	 */
	protected SettingsRepositoryInterface $settings;

	/**
	 * Data hook.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 */
	public function __construct(SettingsRepositoryInterface $settings) {
		$this->settings = $settings;
	}

	/**
	 * Add data to document.
	 *
	 * @param Document $view Document view.
	 * @param Request $request Request object.
	 */
	public function __invoke(Document $view, Request $request): void {
		Core::addPayload($view, $this->settings);
	}
}
