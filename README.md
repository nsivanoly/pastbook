<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Setup the Application
- Clone the Application
- Update the dependencies [composer update]
- Configure the environment [.env]
    - Mail configurations
    - Database configurations
    - Provide the facebook app configuration
- Run `php artisan key:generate`
- Run `php artisan config:cache`
- Run `php artisan migrate`
- Run `php artisan queue:work`
- Test the application

## Setup the Application Docker
- Clone the Application
- Update the dependencies [composer update]
- Configure the environment [.env]
    - Mail configurations
    - Database configurations
    - Provide the facebook app configuration
- Run `docker-compose up -d`
- Run `docker-compose exec app php artisan key:generate`
- Run `docker-compose exec app php artisan config:cache`
- Run `docker-compose exec app php artisan migrate`
- Run `docker-compose exec app php artisan queue:work`
- Test the application

### Note
Configure the Facebook APP to enables the domain and the callbacks
