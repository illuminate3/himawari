# Himawari (CMS) : Laravel 5.1.x Beta Development


## Status / Version

Beta Development


## Description

This module provides a base CMS as in page management.


## Functionality


### Contents
Mulit-lingual Content Management


### Print Statuses
Simple print designations such as draft, edit, in print and such.


## Routes

* /admin/contents
* /admin/print_statuses
* /{page}


## Install


### publish commands

General Publish "ALL" method
```
php artisan vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider"
```

Specific Publish tags
```
php artisan vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="configs"
php artisan vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="images"
php artisan vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="vendors"
php artisan vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="views"
```


## Packages

Intended to be used with:

* https://github.com/illuminate3/rakkoII
* https://github.com/illuminate3/Kagi

The Following are packages that are specific to this module:

* https://github.com/etrepat/baum
* https://github.com/cviebrock/eloquent-sluggable


## Screen Shots
## Thanks
