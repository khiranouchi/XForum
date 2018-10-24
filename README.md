XForum
============
Website: COMING SOON <br>
You can create simple public/private forum page. <br>
Participants don't need any sign up or log in. Even forum creator can skip sign up.

Requirements
--------
+ PHP  7.1.3
+ MariaDB  10.1.*
+ Laravel  5.7.*

Install and Run
--------

1. Install PHP, MariaDB and Laravel.

1. Create one database.

1. Create `.env` file in the laravel root directory.
    1. Copy `.env.example` and rename it to `.env`.
    1. Set `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` according to database you created.
    1. Set `MAIL_*`s according to your mail server.
    1. Set `APP_URL` your server's path of the project root.
    1. Set `APP_NAME` as you like (eg. 'XForum').

1. Run the migrations to create database tables.

        php artisan migrate

1. Run server.

Usage
--------
TODO
