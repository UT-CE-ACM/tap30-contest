# Tap30 Contest

This project has been powered by UT-ACM on laravel 5.3 framework for Tap30 contest! 

## Project Deployment

After cloning the project run following commands in project root:

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

* Each time you want to see the project, build a built-in php server with following command:
~~~
php artisan serve
~~~
Then the project will be served on folloing address:
http://localhost:8000/
