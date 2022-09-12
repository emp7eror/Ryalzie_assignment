# Ryalzie assignment (basic Bank System)
## Managing clients and transaction for the branches of bank 


[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)


## Include

- WEB Application
- Restful Api's 
- Postman File


> This Project not full ready for producation
>  I do my best to complete task at the time .



## Tech

- [Laravel] -Framework
- [Bootstrap] - Interface
- [Mysql] -Database.



## Installation

Make sure that you installed PHP >=8.0 , Mysql , Nginx or Apache 

Install the dependencies and devDependencies and start the server.

```sh
git clone https://github.com/emp7eror/Ryalzie_assignment.git
cd Ryalzie_assignment
composer install
cp .env.example .env
nano .env
```
Create Database and user using phpmyadmin or mysql and edit env file with database credential as below 

```env
DB_DATABASE=edit_this // the database name
DB_USERNAME=edit_this// the database username
DB_PASSWORD=edit_this   // the database password
```
getting things ready Please be patient while seeding we will create 100k row and its takes some time.

```sh
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan passport:install
npm install
npm run build
```

ALl things are done (1 step remaining )
Now feel free to test api using postman file including on Ryalzie_assignment/postman folder
Or login and test the web version
to do that you should serve laravel for temporary or assign the project to domain and add it to apache
## Testing 

For testing we will serve laravel temporary to do that :

```sh
php artisan serve
```

this command will host the project localy and it return the link you can use


## Attention  
Dont Forget use auth when using postman

## License

MIT

