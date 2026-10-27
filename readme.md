# Drago Project user

A small helper package for working with the authenticated user in Drago project.
Provides type-safe access to identity data and a simple, extensible user identity object.

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-user.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-user)
[![Coding Style](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml)

## Requirements

- PHP >= 8.3, < 9
- Nette Framework
- Drago Project core packages

## Installation

```bash
composer require drago-ex/project-user
```

## Project files

File copying is handled automatically by [drago-ex/project-tools](https://github.com/drago-ex/project-tools),
which must be installed in your project. Without it, copy the files manually according to the `copy` section
in this package's `composer.json`. To skip this package, set `"skip": true` under
`extra.drago-tools.packages.<package-name>` in your root `composer.json`.

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

## Any of several privileges

`isAnyAllowed()` is true when the user may do at least one of the privileges on a resource, e.g. to show
a menu item that leads to several actions:
```php
$currentUser->isAnyAllowed('Backend:Blog', 'default-read', 'comments-read');
```

## Showing what the user may use

`isPermitted()` is `isAnyAllowed()` for menus and buttons: without an authorizator (no drago-ex/permission)
it is always true, and a resource the ACL does not know is denied instead of throwing. Each role is asked on its own,
so a role the ACL does not know (e.g. a stale one in the session) does not deny the others:
```php
$currentUser->isPermitted('Backend:Blog', 'articles-write');
```

## Notes

- This package does not sign users in; it gives safe access to the identity data and the permission checks above
  (the ACL itself comes from drago-ex/permission).
