# Tap30 Contest

This ptoject has power by UT-ACM on laravel 5.3 framework for tap30 contest! 

## Project Deployment

After cloning the project run following commands:

* In order to install dependencies and laravel package
~~~
composer install
~~~~

---

* In order to create tables
~~~
php artisan migrate --seed
~~~
**Note:** Before that you have to create a mysql database with *tap30_contest* name

---

* Copy attached .env file to project root and set your mysql config in this file 

**Note:** You should only set DB_USERNAME and DB_PASSWORD variables

---

* Each time you wanted to see the project, build a built-in php server with following command:
~~~
php artisan serve
~~~
Then the project will be served on folloing address:
http://localhost:8000/
