# Client Manager

```Dil Krishna Pila Shrestha``` ```pila``` ```dilkrishnapila@gmail.com``` ```pila``` ```clientmanager```

Client Manager is a package that has feature to manage clients(add and listing). This package uses [Laravel CSV package](https://packagist.org/packages/wilgucki/csv) to read and write csv file

## Install

Via Composer

``` bash
composer require dilpila/clientmanager
```

Add providers ``` Pila\ClientManager\ClientManagerServiceProvider::class ``` in config/app.php

run
``` bash
$ php artisan vendor:publish
```
## Usage
Available routes ``` /clients, /clients/create```

## Testing

``` bash
$ phpunit vendor/dilpila/clientmanager/
```
