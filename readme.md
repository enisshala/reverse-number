## REVERSE NUMBER


This is a web app built with Laravel that works as reverse number lookup

Twilio API is used to retrieve number details

PaypalSDK is used to subscribe users and use the service on recurring basis

IPStack is used to get user location and use different Twilio api calls for European Users and North American users

Laravel Boilerplate was used as a starter

###Credentials

**User:** admin@admin.com  
**Password:** secret

### Installation
1. Download the files above and place on your server.
2. Environment Files - copy content from *.env.example* and create a .env file in the root of the project
3. Composer - run **composer install**
4. NPM/Yarn - run **npm install** or if you have Yarn run **yarn**
5. Create Database - You must create your database on your server and on your .env file update the following lines:

    `DB_CONNECTION=mysql`
    
    `DB_HOST=127.0.0.1`
    
    `DB_PORT=3306`
    
    `DB_DATABASE=homestead`
    
    `DB_USERNAME=homestead`
    
    `DB_PASSWORD=secret`

6. Replace API keys in .env file (PAYPAL, TWILIO, IPSTACK, MAIL SMTP)

7. Artisan Commands

    `php artisan key:generate`
    
    `php artisan migrate`
    
    `php artisan db:seed`

8. Storage:link

    `php artisan storage:link`



##### Official Documentation of Laravel BoilerPlate

[Click here for the official documentation](http://laravel-boilerplate.com)
