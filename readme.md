## Drago Project user
A small helper package for working with the authenticated user in Nette.
Provides type-safe access to identity data and a simple, extensible user identity object.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://raw.githubusercontent.com/drago-ex/project-user/main/license)
[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-user.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-user)
[![Coding Style](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml)

## Requirements
- PHP >= 8.3
- Nette Framework
- Drago Project core packages

## Install
```bash
composer require drago-ex/project-user
```

## Usage
Injecting the user service:
```php
use App\Core\User\UserAccess;
use Nette\DI\Attributes\Inject;

final class SomePresenter extends Presenter
{
	#[Inject]
	public UserAccess $userAccess;

	protected function beforeRender(): void
	{
		parent::beforeRender();
		$this->template->userAccess = $this->userAccess;
	}
}
```

## Identity data in latte
```latte
{varType App\Core\User\UserAccess $userAccess}
{block content}
	<p>{$userAccess->getUserIdentity()->username}</p>
{/block}
```

## User identity object
For common identity fields, use the typed UserIdentity object:
```php
$identity = $userAccess->getUserIdentity();

echo $identity->username;
echo $identity->email;
```

The UserIdentity class is intentionally simple and can be extended
with additional attributes (e.g. id, roles, permissions) as needed.

UserIdentityException is thrown when identity data is missing or invalid.

## Notes
This package does not handle authentication or authorization.
Focused only on safe and convenient access to user identity data.
