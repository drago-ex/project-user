# Drago Project user

[English](readme.md) | Čeština

Malý pomocný balíček pro práci s přihlášeným uživatelem v projektu Drago.
Poskytuje typově bezpečný přístup k údajům identity a jednoduchý, rozšiřitelný objekt identity.

[![PHP version](https://badge.fury.io/ph/drago-ex%2Fproject-user.svg)](https://badge.fury.io/ph/drago-ex%2Fproject-user)
[![Coding Style](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml/badge.svg)](https://github.com/drago-ex/project-user/actions/workflows/coding-style.yml)

## Požadavky

- PHP >= 8.3, < 9
- Nette Framework
- Základní balíčky Drago Project

## Instalace

```bash
composer require drago-ex/project-user
```

## Soubory projektu

Kopírování souborů obstarává automaticky [drago-ex/project-tools](https://github.com/drago-ex/project-tools),
který musí být v projektu nainstalovaný. Bez něj zkopírujte soubory ručně podle sekce `copy`
v `composer.json` tohoto balíčku. Pro přeskočení balíčku nastavte `"skip": true` v
`extra.drago-tools.packages.<package-name>` v kořenovém `composer.json`.

## Příklady

Předání služby uživatele:
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

## Údaje identity v Latte

```latte
{varType App\Core\Security\CurrentUser $currentUser}
{block content}
	<p>{$currentUser->getUserIdentity()->username}</p>
{/block}
```

## Objekt identity uživatele

Pro běžné údaje identity použijte typovaný objekt UserIdentity:
```php
$identity = $currentUser->getUserIdentity();

echo $identity->username;
echo $identity->email;
```

Třída UserIdentity je záměrně jednoduchá a podle potřeby ji lze rozšířit
o další atributy (např. id, role, oprávnění).

Když údaje identity chybí nebo jsou neplatné, vyhodí se UserIdentityException.

## Alespoň jedno z několika privilegií

`isAnyAllowed()` vrací true, když uživatel smí aspoň jedno z privilegií nad zdrojem, například pro zobrazení
položky menu, která vede k několika akcím:
```php
$currentUser->isAnyAllowed('Backend:Blog', 'default-read', 'comments-read');
```

## Zobrazení toho, co uživatel smí použít

`isPermitted()` je `isAnyAllowed()` pro menu a tlačítka: bez autorizátoru (bez drago-ex/permission)
vrací vždy true a zdroj, který ACL nezná, je zamítnut místo vyhození výjimky:
```php
$currentUser->isPermitted('Backend:Blog', 'articles-write');
```

## Poznámky

- Balíček neřeší přihlašování ani autorizaci.
- Zaměřuje se jen na bezpečný a pohodlný přístup k údajům identity uživatele.
