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
	 * If an empty string, return null, else return the string.
	 *
	 * @param string|null $str String value.
	 * @return string|null The string or null.
	 */
	public static function emptyStringNull(?string $str) {
		return $str === '' ? null : $str;
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 * @param string $key Setting key.
	 * @return string|null Setting value.
	 */
	public static function setting(
		SettingsRepositoryInterface $settings,
		string $key
	): ?string {
		return $settings->get(static::ID . '.' . $key);
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 * @return string|null Setting value.
	 */
	public static function settingDefault(
		SettingsRepositoryInterface $settings
	): string {
		return static::setting($settings, 'default') ?? '';
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 * @return string|null Setting value.
	 */
	public static function settingDefaultForce(
		SettingsRepositoryInterface $settings
	): bool {
		return (bool)static::setting($settings, 'default_force');
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 * @return string|null Setting value.
	 */
	public static function settingRating(
		SettingsRepositoryInterface $settings
	): string {
		return static::setting($settings, 'rating') ?? '';
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 * @return string|null Setting value.
	 */
	public static function settingDisableLocal(
		SettingsRepositoryInterface $settings
	): bool {
		return (bool)static::setting($settings, 'disable_local');
	}

	/**
	 * Get setting value for this extension.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 * @return string|null Setting value.
	 */
	public static function settingLinkNewTab(
		SettingsRepositoryInterface $settings
	): bool {
		return (bool)static::setting($settings, 'link_new_tab');
	}

	/**
	 * Generate a gravatar URL for an email address.
	 *
	 * @param string $email Email address.
	 * @param array|null $opts Optional options.
	 * @return string Gravatar URL.
	 */
	public static function gravatarUrl(string $email, ?array $opts = null) {
		$opts = $opts === null ? [] : $opts;
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
	 * Get avatar URL for user, or keep existing.
	 *
	 * @param SettingsRepositoryInterface $settings Settings object.
	 * @param User $user User object.
	 * @param string|null $existing Existing URL.
	 * @return string|null Avatar URL.
	 */
	public static function userAvatarUrl(
		SettingsRepositoryInterface $settings,
		User $user,
		?string $existing = null
	): ?string {
		// If an existing avatar and local not disabled, use that.
		if ($existing && !static::settingDisableLocal($settings)) {
			return $existing;
		}

		// Create the Gravatar URL.
		return static::gravatarUrl($user->email, [
			'default' => static::settingDefault($settings),
			'force' => static::settingDefaultForce($settings) ? 'y' : '',
			'rating' => static::settingRating($settings),
			'size' => static::SIZE_LARGEST_2X
		]);
	}

	/**
	 * Add payload to document.
	 *
	 * @param Document $view Document view.
	 * @param SettingsRepositoryInterface $settings Settings object.
	 */
	public static function addPayload(
		Document $view,
		SettingsRepositoryInterface $settings
	): void {
		$view->payload[static::ID] = [
			'disableLocal' => static::settingDisableLocal($settings),
			'linkNewTab' => static::settingLinkNewTab($settings)
		];
	}
}
