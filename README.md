## Test casino

Author: _[Roman Yankovenko](roman@yankovenko.ru)_

## Instalation
Install vendors packages.
```
composer install
```
Configure connection to mysql server in file `.env`.

Create database structure and fixtures.
```
php artisan migrate
php artisan db:seed
```

## Start server 

```
php artisan serve
```

## Commandline

Command for sending orders to the bank for money prizes.
Optional parameter *number* limits the number of processed records.
```
php artisan casino:send2bank {number}
```

## Unit tests

```
phpunit
```

