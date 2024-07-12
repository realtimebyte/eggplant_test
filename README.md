# Eggplant Technical Test

## Description:

Technical Assessment of Eggplant.
This is providing information of the city and region which is between rangeStart and rangeBetween when we input the our ip in textbox, so we can get the information about the city of ip.

## How to install.

### 1. Backend

_Step 1. Install the Laravel_

Backend is built by Laravel Framework.
You must install the composer and php in your os system to install backend smoothly. You can refer the [Laravel Document](https://laravel.com/docs/7.x/installation).

_Step 2. Install the MySQL and PHP_

You must install MySQL DB to upgrade the City-IP Lite CSV to Database. I recommend you to install Xampp. You can download the [Xampp](https://www.apachefriends.org/download.html) here.

_Step 3. Create Database and import database to db_

Create Database - laravel
Run this SQL Query in laravel database

```
CREATE TABLE `dbip_lookup` (
  `addr_type` enum('ipv4','ipv6') NOT NULL,
  `ip_start` varbinary(16) NOT NULL,
  `ip_end` varbinary(16) NOT NULL,
  `continent` char(2) NOT NULL,
  `country` char(2) NOT NULL,
  `stateprov` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  PRIMARY KEY (`addr_type`,`ip_start`)
) DEFAULT CHARSET=utf8mb4;
```

And Go to the backend/dbip folder, run the php command

```
./import.php -f dbip-city-lite-2024.07.csv.gz -d city-lite -b laravel -t dbip_lookup
```

Above one is the Unix command (Linux and Mac), You need to use the command in windows like this

```
import.php -f dbip-city-lite-2024.07.csv.gz -d city-lite -b laravel -t dbip_lookup
```

After running the command, check the database if 6M+ records added.

_Step 4. Check the Configuration and Run Laravel Application_
Copy the .env.example file and rename by .env file, then check the mysql configuration in .env file.
And then run the command

```
php artisan serve
```

After run command, check the server running on [http://127.0.0.1:8000]

Test the api by postman easy.

### 2. Frontend

_Step 1. Install the Node_

Frontend is built by Angular and you need to install the Node and Angular CLI globally. Please refer this documentation: [Angular Doc]('https://v17.angular.io/cli'), [Node Installation](https://nodejs.org/en).

_Step 2. Install the App_

Go to the frontend/ip_lookup and run `npm install`

And then you can run the application using this command `npm run start`

You can see the text input and type the ip address like 2.4.5.6

You can see the information of the city below text input.

---

## Thanks for watching steps
