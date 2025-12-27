<?php

declare(strict_types=1);

namespace App\Core\User;

use Nette\Application\UI\Presenter;


trait UserRequireLogged
{
	/**
	 * Function that ensures the user is logged in.
	 * If the user is not logged in, they will be redirected to the login page.
	 * If the user was logged out due to inactivity, a message will be displayed.
	 */
	public function injectRequireLoggedUser(Presenter $presenter, UserAccess $userAccess): void
	{
		// When the application starts, check the user's login status.
		$presenter->onStartup[] = function () use ($presenter, $userAccess) {
			// If the user is logged in, no action is taken.
			if ($userAccess->isLoggedIn()) {
				return;
			}

			// If the user was logged out due to inactivity, display a message and redirect them to the login page.
			if ($userAccess->getLogoutReason() === $userAccess::LogoutInactivity) {
				$presenter->flashMessage('You have been signed out due to inactivity. Please sign in again.');
				$presenter->redirect(':Backend:Sign:in', ['backlink' => $presenter->storeRequest()]);
			} else {
				// If the user is not logged in for any other reason, redirect them to the login page.
				$presenter->redirect(':Backend:Sign:in');
			}
		};
	}
}
