# How To Use This Repository

## System Requirements
* PHP Version > 7.2
* Install composer globally on your System Operation
* Install Git Bash (if you clone project)

## Get Repository/Project Files

* Clone Project to your directory web service using command this
```js
    git clone https://github.com/alpredoRuben/sample_project.git
```

* If you don't install git bash, you must download [repository](https://github.com/alpredoRuben/sample_project.git) 


## After Clone Or Download Repository/Project Files

* Download/Install Package using composer

```js
    cd sample_project

    composer install
```

* After Install composer, Set your database on file .env
```js
    //File .env
    DB_CONNECTION=mysql
    DB_HOST=your_database_ip
    DB_PORT=your_database_port
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
```

* Set Key Generate
```js
    php artisan key:generate
```

* Run migration and seeder
  
```js
    php artisan migrate:fresh --seed
```

* Run service app
```js
    php artisan serve
```
