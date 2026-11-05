# Drago Project User

The signed-in user of Drago Project with typed access to the identity data (username, email).

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-user.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-user)
[![Coding Style](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml)

## Requirements

- PHP >= 8.3, < 9
- [Drago Project](https://github.com/drago-ex/project)

## Installation

```bash
composer require drago-ex/project-user
```

[Project Tools](https://github.com/drago-ex/project-tools) copies the files of the package into
`app/Core/Security`, where you adapt them. `UserConf.neon` replaces the Nette `user` service with
`App\Core\Security\CurrentUser`, so `$user` in presenters and templates is `CurrentUser`.

## Usage

```php
use App\Core\Security\CurrentUser;
use Nette\DI\Attributes\Inject;

final class SomePresenter extends Presenter
{
	#[Inject]
	public CurrentUser $currentUser;
}
```

```php
$identity = $currentUser->getUserIdentity();

echo $identity->username;
echo $identity->email;
```

```latte
{varType App\Core\Security\CurrentUser $user}
<p>{$user->getUserIdentity()->username}</p>
```

`UserIdentityException` is thrown when the identity data is missing or invalid. Extend `UserIdentity` with
further fields your project stores in the identity.
