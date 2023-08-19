# Laravel Project Modules

## Features

-   Laravel project based on Quickadmin Panel
-   Laravel <b>8.x</b>
-   Php Version <b>^7.3|^8.0</b>
-   Default API Response Format
-   Multiple Language Settings
-   Sample Encrypt and Decrypt Function in middleware
-   Log Viewer [Github Pages](https://github.com/rap2hpoutre/laravel-log-viewer)
-   Change the way the log is recorded
-   Can Create new modules with the artisan command (Module Functions)
-   Route format
-   Api Doc [Github Pages](https://github.com/zhangweiwei0326/laravel-apidoc) or you can use at the [Postman](https://www.postman.com/) API Doc
-   Image API
-   Will continue to update...

<hr>

## Installation and Setup

First, make sure install <a href="https://laravel.com/"><b>Laravel 8.\*</b></a> and, and <a href="https://getcomposer.org/download/"><b>Composer</b></a> in your devices.

Second, copy .env.example file to .env and edit database credentials there.

and Run the following command:

```
composer install
```

```
php artisan key:generate
```

```
php artisan migrate --seed
```

Last, run the project with:

```
php artisan serve
```

and Open browser with http://localhost:8000/</br>
Login inforamtion:</br>
Email: admin@admin.com</br>
Password: password

<hr>

## FAQ

1. Why use this?<br>
   Answer: Quickly start a Laravel project. No need to set up cumbersome composer package at the beginning

2. What is the Module Function?<br>
   Answer: Module Function is a create a module quickly. There is no need to create controllers, models and so on step by step.

3. Any Contact?<br>
   Answer: You can email me. <b>jianhuiwilliam80@gmail.com</b>

<hr>

## Modules Function

Command:

```
php artisan create:module {module name}
```

When you type the command, you will get the following list:

-   ModuleNameController
-   ModuleNameApiController
-   StoreModuleNameRequest
-   UpdateModuleNameRequest
-   Migartion File
-   Models File
-   Layout File include index, edit, show and create pages

<hr>

## Postman API Documentation

<a href="https://documenter.getpostman.com/view/15219123/Uz5CLHv9">Link</a>

---

## Remark

In the Layout File, You can use the Ctrl+F and search Keyword <b>"Name"</b>, you can change to the module name.

---

## License

`Laravel Project Modules` is licensed under [The MIT License (MIT)](License.md).
