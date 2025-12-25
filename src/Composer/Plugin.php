<?php

declare(strict_types=1);

namespace Drago\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Drago\Installer;


final class Plugin implements PluginInterface, EventSubscriberInterface
{
	public static function getSubscribedEvents(): array
	{
		return [
			'post-autoload-dump' => 'onPostAutoloadDump',
		];
	}


	public function activate(Composer $composer, IOInterface $io)
	{
		// Aktivace pluginu není potřeba nic speciálního
	}


	public function deactivate(Composer $composer, IOInterface $io)
	{
		// Deaktivace pluginu
	}


	public function uninstall(Composer $composer, IOInterface $io)
	{
		// Odinstalace pluginu
	}


	public function onPostAutoloadDump(): void
	{
		Installer::install();
	}
}
