## Laravel Image Manipulation REST API

## Demo
Here is fully working Demo: https://www.lobiimages.com/ <br>
You have to register first in order to generate access token and make API requests.<br>

#### Test locally
Download [postman_collection.json](postman_collection.json) file, import it in your postman and test locally.

## Prerequisites

#### PHP Extensions
`php-mbstring php-dom php-intl php-curl php-mysql php-gd`

## Basic installation steps 
Before you start the installation process you need to have **installed composer**

1. Clone the project
2. Navigate to the project root directory using command line
3. Run `composer install`
4. Copy `.env.example` into `.env` file
5. Adjust `DB_*` parameters.<br> 
   If you want to use Mysql, make sure you have mysql server up and running. <br>
   If you want to use sqlite: 
   1. you can just delete all `DB_*` parameters except `DB_CONNECTION` and set its value to `sqlite`
   2. Then create file `database/database.sqlite`
6. Run `php artisan key:generate --ansi`
7. Run `php artisan migrate`

### Installing locally for development
Run `php artisan serve` which will start the server at http://localhost:8000 <br>


### Installing on production
1. Create a virtual host file
2. Enable it
3. Reload apache

Virtual host template.
```apacheconf
<VirtualHost *:80>
    ServerName yourproductiondomain.com
    ServerAlias www.yourproductiondomain.com
    DocumentRoot /project-installation-path/public

    <Directory "/project-installation-path/public`">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /path-to-logs-folder/error.log
    CustomLog /path-to-logs-folder/access.log combined
</VirtualHost>
```
If you installed the project using apache and have any issues regarding permissions when installing on production,
do the following. 
1. Add the project owner user in `www-data` group
    ```shell
    sudo usermod -a -G www-data project-owner-user
    ```
2. Change the owner of several folders into `www-data` user
    ```shell
    chown www-data:www-data storage/ -R
    chown www-data:www-data public/images
    ```


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
