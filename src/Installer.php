<?php

declare(strict_types=1);

namespace Drago;

use FilesystemIterator;


final class Installer
{
	public static function install(): void
	{
		$root = self::getProjectRoot();
		self::copy(
			__DIR__ . '/../User',
			$root . '/app/Core/User',
		);

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
			if (file_exists($destination)) {
				echo "[project-user] Skipped (exists): $destination\n";
				return;
			}
			@mkdir(dirname($destination), 0777, true);
			copy($source, $destination);
			return;
		}

		if (is_dir($source)) {
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
					@mkdir($targetPath, 0777, true);
				} else {
					copy($item->getPathname(), $targetPath);
				}
			}
		}
	}
}
