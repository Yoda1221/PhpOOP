# Php OOP
### Created 2022. 08. 17.

## COMPOSER
- symfony/var-dumper
- vlucas/phpdotenv

## Create folders
md controllers core migrations models public views views/layouts

## Create files
touch .env .env.example .gitignore composer.json migrations.php
touch views/home.php views/contact.php views/_404.php views/layouts/main.php public/index.php
touch core/Database.php core/Application.php controllers/SiteController.php
touch core/Controller.php core/Router.php core/Request.php core/Response.php

## User Guide
- Clone the program from Git repository [Yoda1221/PHP-Logn](https://github.com/Yoda1221/PHP-Login.git)
- Run the following command: composer dump-autoload -o
- Run from root directory the migrations.php ( php migrations.php )
- Run the program from the public folder with the following command: php -S localhost:8080 or on any other port