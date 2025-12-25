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

## How to use
```php
#[Inject]
public App\Core\User\User $user;
```

## In the template
```php
protected function beforeRender(): void
{
	parent::beforeRender();
	$this->template->user = $this->user;
}
```

## Access to identity data
```latte
{varType App\Core\User\User $user}
{block content}
	<p>{$user->getUserIdentity()->username}</p>
{/block}
```

## Secure access to the section
```php
final class SecurePresenter extends Presenter
{
	use App\Core\User\UserRequireLogged;
}
```
