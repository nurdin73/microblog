## MICROBLOG
### System Requirements
* [Linux](https://www.linux.org/download/ubuntu/)
* [Ubuntu](https://www.ubuntu.com/download/desktop)
* [Windows](https://www.microsoft.com/en-us/download/details.aspx?id=48212)
* [MacOS](https://www.apple.com/osx/)
* [Git](https://git-scm.com/downloads)
* [PHP](https://www.php.net/downloads.php)
* [MySQL](https://www.mysql.com/products/workbench/)
* [PostgreSQL](https://www.postgresql.org/download/)
* [Apache](https://httpd.apache.org/download.cgi)
* [Nginx](https://nginx.org/en/download.html)

### Installation
* Clone the repository
``` 
git clone https://github.com/nurdin73/microblog.git
```
* Install the dependencies
```
composer install
```
* Copy the configuration file .env.example to .env
* Change the database configuration in .env
```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=root
  DB_PASSWORD=  
```
* Change the mail configuration in .env
```
  MAIL_MAILER=smtp
  MAIL_HOST=mailhog
  MAIL_PORT=1025
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS="hello@example.com"
  MAIL_FROM_NAME="${APP_NAME}"
```
* Add Shopify configuration in .env
```
  SHOPIFY_API_KEY=
  SHOPIFY_SECRET_KEY=
  SHOPIFY_ACCESS_TOKEN=
  SHOPIFY_STORE_NAME=
  SHOPIFY_API_VERSION=
  SHOPIFY_API_TYPE=storefront_api
```

* Generate the key
```
php artisan key:generate
```
* Run the database migration
``` 
php artisan migrate
```
* Run the database seeder
``` 
php artisan db:seed
```
* Run the application
``` 
php artisan serve
```
* Open the browser and go to http://localhost:8000/

* Login with the following credentials
```
  email: system@system.com
  password: password
```