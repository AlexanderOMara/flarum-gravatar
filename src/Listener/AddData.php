<?php

namespace AlexanderOMara\FlarumGravatar\Listener;

use Flarum\Frontend\Document;
use Psr\Http\Message\ServerRequestInterface as Request;

use AlexanderOMara\FlarumGravatar\Core;

/**
 * Data hook.
 */
class AddData {
	/**
	 * Core object.
	 *
	 * @var Core
	 */
	protected /*Core*/ $core;

	/**
	 * Data hook.
	 *
	 * @param Core $core SCore object.
	 */
	public function __construct(Core $core) {
		$this->core = $core;
	}

	/**
	 * Add data to document.
	 *
	 * @param Document $view Document view.
	 * @param Request $request Request object.
	 */
	public function __invoke(Document $view, Request $request): void {
		$this->core->addPayload($view);
	}
}
