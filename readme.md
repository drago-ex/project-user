## Drago Project user
A user management and authentication package for the Drago Project.
Provides secure and type-consistent access to user data, authentication, tokens, and access protection.

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-user.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-user)
[![Coding Style](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml)

## Main features
- User identity management via User and UserIdentity
- Authentication and token management via UserRepository
- Centralized access protection via the UserRequireLogged trait
- Type-safe exceptions and interfaces (UserIdentityException, UserToken)
- UsersEntity data entity for working with users in the database
- Easy integration with Nette DI

## Install
```bash
composer config --no-plugins allow-plugins.drago-ex/project-user true
composer require drago-ex/project-user
composer remove drago-ex/project-user --no-interaction
```

## How to use
```php
#[Inject]
public App\Core\User\UserAccess $userAccess;
```

## In the template
```php
protected function beforeRender(): void
{
	parent::beforeRender();
	$this->template->userAccess = $this->userAccess;
}
```

## Access to identity data
```latte
{varType App\Core\User\UserAccess $userAccess}
{block content}
	<p>{$userAccess->getUserIdentity()->username}</p>
{/block}
```

## Secure access to the section
```php
final class SecurePresenter extends Presenter
{
	use App\Core\User\UserRequireLogged;
}
```
