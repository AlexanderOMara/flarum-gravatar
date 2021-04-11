<?php

namespace AlexanderOMara\FlarumGravatar;

use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;

/**
 * Core functionality.
 */
class Core {
	/**
	 * Extension identifier.
	 *
	 * @var string
	 */
	public const ID = 'alexanderomara-gravatar';

	/**
	 * Largest usage is 96, use 2x for higher DPX screens.
	 *
	 * @var int
	 */
	public const SIZE_LARGEST_2X = (96 * 2);

	/**
	 * Settings object.
	 *
	 * @var SettingsRepositoryInterface
	 */
	protected /*SettingsRepositoryInterface*/ $settings;

	/**
	 * Core functionality.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 */
	public function __construct(SettingsRepositoryInterface $settings) {
		$this->settings = $settings;
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @param string $key Setting key.
	 * @return string|null Setting value.
	 */
	public function setting(string $key): ?string {
		return $this->settings->get(static::ID . '.' . $key);
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @return string|null Setting value.
	 */
	public function settingDefault(): string {
		return $this->setting('default') ?? '';
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @return string|null Setting value.
	 */
	public function settingDefaultForce(): bool {
		return (bool)$this->setting('default_force');
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @return string|null Setting value.
	 */
	public function settingRating(): string {
		return $this->setting('rating') ?? '';
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @return string|null Setting value.
	 */
	public function settingDisableLocal(): bool {
		return (bool)$this->setting('disable_local');
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @return string|null Setting value.
	 */
	public function settingLinkNewTab(): bool {
		return (bool)$this->setting('link_new_tab');
	}

	/**
	 * Get avatar URL for email, or keep existing.
	 *
	 * @param string $email The email.
	 * @param string|null $existing Existing URL.
	 * @return string|null Avatar URL.
	 */
	public function avatarUrl(
		string $email,
		?string $existing = null
	): ?string {
		// If an existing avatar and local not disabled, use that.
		if ($existing && !$this->settingDisableLocal()) {
			return $existing;
		}

		// Create the Gravatar URL.
		return static::gravatarUrl($email, [
			'default' => $this->settingDefault(),
			'force' => $this->settingDefaultForce() ? 'y' : '',
			'rating' => $this->settingRating(),
			'size' => static::SIZE_LARGEST_2X
		]);
	}

	/**
	 * Add payload to document.
	 *
	 * @param Document $view Document view.
	 */
	public function addPayload(Document $view): void {
		$view->payload[static::ID] = [
			'disableLocal' => $this->settingDisableLocal(),
			'linkNewTab' => $this->settingLinkNewTab()
		];
	}

	/**
	 * Generate a gravatar URL for an email address.
	 *
	 * @param string $email Email address.
	 * @param array|null $opts Optional options.
	 * @return string Gravatar URL.
	 */
	public static function gravatarUrl(string $email, ?array $opts = null) {
		$opts = $opts ?: null;
		$hash = md5(strtolower(trim($email)));
		$query = http_build_query([
			'd' => static::emptyStringNull($opts['default'] ?? null),
			'f' => static::emptyStringNull($opts['force'] ?? null),
			'r' => static::emptyStringNull($opts['rating'] ?? null),
			's' => static::emptyStringNull($opts['size'] ?? null),
		]);
		$sep = strlen($query) ? '?' : '';
		return "https://www.gravatar.com/avatar/{$hash}{$sep}{$query}";
	}

	/**
	 * If an empty string, return null, else return the value.
	 *
	 * @param mixed $str The value.
	 * @return string|null The string or null.
	 */
	public static function emptyStringNull($value) {
		return $value === '' ? null : $value;
	}
}
