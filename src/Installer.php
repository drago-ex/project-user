<?php

declare(strict_types=1);

namespace Drago;

use FilesystemIterator;


final class Installer
{
	public static function install(): void
	{
		$root = self::getProjectRoot();
		$source = __DIR__ . '/../User';
		$destination = $root . '/app/Core/User';

		if (!is_dir($source)) {
			echo "[project-user] Source directory not found: $source\n";
			return;
		}

		self::copy($source, $destination);

		echo "[project-user] User support installed\n";
	}


	private static function getProjectRoot(): string
	{
		// vendor/drago-ex/project-user/src → ROOT
		return dirname(__DIR__, 4);
	}


	private static function copy(string $source, string $destination): void
	{
		if (is_file($source)) {
			@mkdir(dirname($destination), 0o777, true);
			copy($source, $destination);
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(
				$source,
				FilesystemIterator::SKIP_DOTS,
			),
			\RecursiveIteratorIterator::SELF_FIRST,
		);

		foreach ($iterator as $item) {
			$subPath = $iterator->getSubIterator($iterator->getDepth())->getSubPathName();
			$targetPath = $destination . DIRECTORY_SEPARATOR . $subPath;

			if ($item->isDir()) {
				@mkdir($targetPath, 0o777, true);
			} else {
				copy($item->getPathname(), $targetPath);
			}
		}
	}
}
