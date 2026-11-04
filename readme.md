# Drago Project user

A small helper package for working with the authenticated user in Drago project.
Provides type-safe access to identity data and a simple, extensible user identity object.

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-user.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-user)
[![Coding Style](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml)

## Requirements

- PHP >= 8.3, < 9
- [Drago Project](https://github.com/drago-ex/project)

## Installation

```bash
composer require drago-ex/project-user
```

## Files copied into the project

The files are copied into the project by [drago-ex/project-tools](https://github.com/drago-ex/project-tools),
as set in `extra.drago-tools` of this package's `composer.json`.

## Examples

Injecting the user service:
```php
use App\Core\Security\CurrentUser;
use Nette\DI\Attributes\Inject;

final class SomePresenter extends Presenter
{
	#[Inject]
	public CurrentUser $currentUser;

	protected function beforeRender(): void
	{
		parent::beforeRender();
		$this->template->currentUser = $this->currentUser;
	}
}
```

## Identity data in latte

```latte
{varType App\Core\Security\CurrentUser $currentUser}
{block content}
	<p>{$currentUser->getUserIdentity()->username}</p>
{/block}
```

## User identity object

For common identity fields, use the typed UserIdentity object:
```php
$identity = $currentUser->getUserIdentity();

echo $identity->username;
echo $identity->email;
```

The UserIdentity class is intentionally simple and can be extended
with additional attributes (e.g. id, roles, permissions) as needed.

UserIdentityException is thrown when identity data is missing or invalid.

## Notes

- This package does not sign users in; it gives safe access to the identity data (permission checks come from
  drago-ex/permission).
