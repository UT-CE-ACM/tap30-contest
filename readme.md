# Tap30 Contest

This ptoject has power by UT-ACM with laravel 5.3 framework for tap30 contest! 

## Project Deployment

After cloning the project run following commands:

1. In order to install dependencies and laravel package
~~~
composer install
~~~~

2. In order to create tables
~~~
php artisan migrate --seed
~~~
**Note:** Before that you have to create a mysql database with *tap30_contest* name

3. Each time you wanted to see the project, build a built-in php server with following command:
~~~
php artisan serve
~~~
then the project will be served on folloing address:
http://localhost:8000/
