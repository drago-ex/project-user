<?php

declare(strict_types=1);

namespace DragoUserPlugin;


final class Installer
{
	public static function install(): void
	{
		$root = self::getProjectRoot();
		$projectRoot = $root . '/app/Core/User';
		$files = [
			'User.php',
			'UserConf.neon',
			'UserIdentity.php',
			'UserIdentityException.php',
			'UserRepository.php',
			'UserRequireLogged.php',
			'UserEntity.php',
			'UserToken.php',
		];

		foreach ($files as $file) {
			self::copy(__DIR__ . '/../resources/User/' . $file, $projectRoot . '/' . basename($file));
		}

		echo "[project-user] User support installed\n";
	}


	private static function getProjectRoot(): string
	{
		// vendor/drago-ex/project-user/src → ROOT
		return dirname(__DIR__, 4);
	}


	private static function copy(string $from, string $to): void
	{
		if (file_exists($to)) {
			echo "[project-user] Skipped (exists): $to\n";
			return;
		}

		@mkdir(dirname($to), 0o777, true);
		copy($from, $to);
	}
}
