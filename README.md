FroZerHinG
==
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat)](LICENSE.md)
[![dotLock-badge](https://img.shields.io/static/v1.svg?label=.lock&message=committed&color=red)](composer.lock)
[![phpVersion-badge](https://img.shields.io/static/v1.svg?label=php&message=7.3%2B&color=green)](https://www.php.net/releases/7_3_0.php)
[![psr1-compliant](https://img.shields.io/static/v1.svg?label=PSR-1&message=compliant&color=green)](https://www.php-fig.org/psr/psr-1/)

## About me!
FroZerHinG (From Zero to Hiring) is a CLI tool developed in PHP.<br />
It get all transactions for a customer, based on it's ID.<br />
They are converted to € if original currency is different.<br />

## Dependencies
FroZerHinG use
- ["Laravel Zero"](https://laravel-zero.com) to manage CLI commands.
- [PHP 7.3+](https://www.php.net/releases/7_3_0.php) (Required by Laravel zero to run)
- [Pest](https://github.com/pestphp/pest) (Testing framework)

## Installation
To install FroZerHinG, run the commands below 
```sh
git clone https://github.com/haxl00/frozerhing.git
composer install
```
Rename .env.example to .env (root folder)

## Running
By default, FroZerHinG list all commands available in the application<br />
**NOTE: If APP_ENV != "local", only custom commands are displayed in command list**
```sh
php frozerhing
```

### Main commands
#### transactionlist
*Basic command*
```sh
php frozerhing transactionlist {customerId}
```

*Command help*
```sh
php frozerhing help transactionlist
```

## Test
FroZerHinG use "Pest" as testing framework, because it is build on top of PHPUnit but it is embedded in "Laravel Zero".<br />
To run test, launch (in Windows or \*nix environment)
```sh
vendor\bin\pest
./vendor/bin/pest
```

## Disclaimer
Due to the purpose of this project, I have decided to use a micro-framework to provide a complete example of using third party software.<br />
Reading and filtering of csv source is all "hand made" (voluntarily) to show how I solve complex problems via code.

## Edited / Created files
*This is the list of edited / created files (including framework files)
- [config/app.php](config/app.php) {edited}
- [config/commands.php](config/commands.php) {edited}
- [config/custom.php](config/custom.php) {created}
- [config/logging.php](config/logging.php) {edited}
- [.env.example](.env.example) {created}
- [.gitignore](.gitignore) {created}
- [phpunit.xml](phpunit.xml) {edited}
- [README.md](README.md) {created}
- [app/Commands/TransactionList.php](app/Commands/TransactionList.php) {created}
- /app/Controllers/\*.\* {created}
- /app/Exceptions/\*.\* {created}
- /app/Helpers/\*.\* {created}
- /app/Models/\*.\* {created}
- /app/Persistence/\*.\* {created}
- [/tests/Feature/TransactionListCommandTest.php](/tests/Feature/TransactionListCommandTest.php) {created}
- /tests/Unit/\*.\* {created}
