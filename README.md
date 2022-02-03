<div class="container">
  <div class="row">
    <div class="col-md-6">
      <p align="center"><img src="https://github.com/lorenzhahaha/pawstop/blob/main/public/img/app-icon.png" width="200px" height="200px"></p>    
    </div>  
  </div> 
</div>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Pawstop 

Pawstop is an e-commerce application made for those people looking to adopt dogs. This website is made from:

- Laravel 8.81.0
- Vue 2.6.14
- Bootstrap 4.6.1
- HTML5
- CSS

## Installation

After `cloning the project`, run the following commands to proceed:
> Copy .env.example to .env and add necessary configuration and create a DB named `pawstop`

```
composer install
npm install && npm run dev
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve (without Virtual hosting)
```

- Virtual hosting is optional. If you can setup a virtual hosting, its preferred to use `pawstop.me` as the domain name to use all of the services of the app stated below:
> Laravel Socialite (Google login) & Google reCAPTCHA

## Screenshots

![Login](https://github.com/lorenzhahaha/pawstop/blob/main/screenshots/login.png)
![Sign Up](https://github.com/lorenzhahaha/pawstop/blob/main/screenshots/signup.png)

## Contributing

This was made personally by Lorenz Florentino.
&#169; Pawstop
