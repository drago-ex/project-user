<?php declare(strict_types=1);

namespace App\Core\Security;

use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Security\Authorizator;
use Nette\Security\User;
use function array_key_exists, is_string;


class CurrentUser extends User
{
	/**
	 * Returns user data from the identity.
	 * @throws UserIdentityException
	 */
	public function getUserData(?string $name = null): mixed
	{
		$data = $this->getIdentity()?->getData() ?? [];

		if ($name !== null && !array_key_exists($name, $data)) {
			throw new UserIdentityException("Undefined array key \"$name\" in identity data.");
		}

		return $name !== null ? $data[$name] : $data;
	}


	/**
	 * Returns the user identity.
	 * @throws UserIdentityException
	 */
	public function getUserIdentity(): UserIdentity
	{
		$username = $this->getUserData('username');
		$email = $this->getUserData('email');

		if (!is_string($username) || !is_string($email)) {
			throw new UserIdentityException('User identity is incomplete.');
		}

		return new UserIdentity(username: $username, email: $email);
	}


	/**
	 * Like isAnyAllowed(), for showing what the user may use (menu items, buttons): without an authorizator
	 * (drago-ex/permission is optional) everything is permitted, and a resource the ACL does not know is not,
	 * as the Authorization trait of drago-ex/permission decides. Without privileges the whole resource is checked.
	 * Each role is asked on its own: a role the ACL does not know (e.g. a stale one in the session) is skipped,
	 * so the other roles of the user still decide.
	 */
	public function isPermitted(string $resource, string ...$privileges): bool
	{
		$authorizator = $this->getAuthorizatorIfExists();
		if ($authorizator === null) {
			return true;
		}

		foreach ($this->getRoles() as $role) {
			foreach ($privileges === [] ? [Authorizator::All] : $privileges as $privilege) {
				try {
					if ($authorizator->isAllowed($role, $resource, $privilege)) {
						return true;
					}
				} catch (InvalidStateException|InvalidArgumentException) {
					// an unknown role or resource, or an empty name, is not allowed
				}
			}
		}

		return false;
	}


	/** True when any role of the user has at least one of the privileges on the resource (e.g. for a menu item). */
	public function isAnyAllowed(string $resource, string ...$privileges): bool
	{
		foreach ($privileges as $privilege) {
			if ($this->isAllowed($resource, $privilege)) {
				return true;
			}
		}

		return false;
	}
}
