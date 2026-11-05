# Agent Guide

`drago-ex/project-user` (type drago-tools-resource, PHP >=8.3 <9): `CurrentUser`, the signed-in user with typed
identity data. The workspace rules are in `../AGENTS.md`; dependencies are in `composer.json`.

## Layout
- `resources/Security` is copied to `app/Core/Security`: `CurrentUser`, `UserIdentity`,
  `UserIdentityException`, `UserConf.neon` (replaces the Nette `user` service with `CurrentUser`).

## How it works
- `CurrentUser::getUserIdentity()` returns username and email from the identity data (`getData()`, never magic
  properties), `UserIdentityException` when missing. The user menus of project-backend-ui and project-front-ui use it.
- `CurrentUser` has no permission checks: menus and buttons use `Drago\Permission\Privilege::isAllowed()` with
  Nette's `User`.

## Commands
```bash
composer phpstan
```
