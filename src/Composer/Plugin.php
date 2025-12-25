<?php

declare(strict_types=1);

namespace Drago\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Drago\Installer;


final class Plugin implements PluginInterface, EventSubscriberInterface
{
	public static function getSubscribedEvents(): array
	{
		return [
			'post-package-install' => 'onPackageInstall',
			'post-package-update'  => 'onPackageInstall',
		];
	}


	public function activate(Composer $composer, IOInterface $io)
	{
		// TODO: Implement activate() method.
	}


	public function deactivate(Composer $composer, IOInterface $io)
	{
		// TODO: Implement deactivate() method.
	}


	public function uninstall(Composer $composer, IOInterface $io)
	{
		// TODO: Implement uninstall() method.
	}


	public function onPackageInstall(PackageEvent $event): void
	{
		$package = $event->getOperation()->getPackage();
		if ($package->getName() === 'drago-ex/project-user') {
			Installer::install();
		}
	}
}
