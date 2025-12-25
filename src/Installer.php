<?php

declare(strict_types=1);

namespace Drago\UserPlugin;


final class Installer
{
	public static function install(): void
	{
		$root = self::getProjectRoot();
		$projectRoot = $root . '/app/Core/User';

		self::copy(__DIR__ . '/../User/User.php', $projectRoot . '/User.php');
		self::copy(__DIR__ . '/../User/UserConf.neon', $projectRoot . '/UserConf.neon');
		self::copy(__DIR__ . '/../User/UserIdentity.php', $projectRoot . '/UserIdentity.php');
		self::copy(__DIR__ . '/../User/UserIdentityException.php', $projectRoot . '/UserIdentityException.php');
		self::copy(__DIR__ . '/../User/UserRepository.php', $projectRoot . '/UserRepository.php');
		self::copy(__DIR__ . '/../User/UserRequireLogged.php', $projectRoot . '/UserRequireLogged.php');
		self::copy(__DIR__ . '/../User/UserEntity.php', $projectRoot . '/UserEntity.php');
		self::copy(__DIR__ . '/../User/UserToken.php', $projectRoot . '/UserToken.php');

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
