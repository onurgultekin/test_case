# About the project

This project is written with **Laravel** version 8. If you want to learn more, you can go to [Laravel documentation](https://laravel.com/docs/8.x)


# How it works?

After you cloned the project to your local environment, you need to install dependencies first. 

    composer install

After that **you have to create a new database called *test_case*** in your local mysql server. If you have an existing database you can config it by editing .env file in the project like below:

To edit the .env file you need to copy .env .example file to .env first.

Open Terminal and run:

    cp .env.example .env

After .env is created you can find DB_CONNECTION parameters, if you want to change.

    DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=test_case
	DB_USERNAME=root
	DB_PASSWORD=root
After you are done with your database, you have to run below command from terminal to make migrations:

    php artisan migrate
After migration is succeeded, you have to run below command in order to insert fake users to users table with Laravel's tinker.
First access to tinker with:

    php artisan tinker

And then

    User::factory()->count(10)->create()

This is going to create 10 fake users to users table.
Once user creation is completed, you can see all users in your users table.

From now on, you can run the project with:

    php artisan serve

## API Usage

This API's authorization is implemented with [Laravel's sanctum](https://laravel.com/docs/8.x/sanctum). So, you will need to use a Bearer token to make requests expect login endpoint.

## Login Endpoint
To get the token, you need send a **POST** request to **login** endpoint with these credentials.

***Endpoint: localhost:8000/api/login***

Method:

**POST**

Headers:

    Content-Type: application/json
    Accept: application/json

Request Body:

    {
        "email": // You can get it from your users table's email column,
        "password": // You can get it from your users table's password column. Send hashed password as it writes in DB.
    }

As a response, you are going to get something like this:

    {
    "user": {
	    "id": 3,
	    "name": "Miss Shyann Hermiston",
	    "email": "kturner@example.net",
	    "email_verified_at": "2020-12-07T17:30:25.000000Z",
	    "created_at": "2020-12-07T17:30:25.000000Z",
	    "updated_at": "2020-12-07T17:30:25.000000Z"
	    },
    "token": "2|RnI7OSXFlBAZkhIgAzC1NpkGccaqLLmRKA0g2v5u"
    }

**Get the token parameter** from this response to use other API endpoints without getting "Unauthorized" errors.

## Meditation Endpoint

This Endpoint is used for retrieving data for meditations on monthly and yearly basis.

***Endpoint: localhost:8000/api/meditation***

Method:

**POST**

Headers:

    Content-Type: application/json
    Accept: application/json
    Authorization: Bearer {token}

Request Body:

    {
        "month": 1,
        "year": 2020
    }
## Last Seven Days Endpoint

This Endpoint is used for retrieving data for meditations for last 7 days only.

***Endpoint: localhost:8000/api/lastSevenDays***

Method:

**GET**

Headers:

    Content-Type: application/json
    Accept: application/json
    Authorization: Bearer {token}
   
## This Month Endpoint

This Endpoint is used for retrieving data for meditations for this month only.

***Endpoint: localhost:8000/api/thisMonth***

Method:

**GET**

Headers:

    Content-Type: application/json
    Accept: application/json
    Authorization: Bearer {token}
