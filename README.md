<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Laravel9 + Pear Admin Layui

- Demo = 
- Account = admin
- Password = admin123456

## Requirement
```bash
- php v8.0
- mysql >= v5.6
- nginx v1.2.0
- linux server
- redis server
- composer
```

## Required PHP extension
```bash
- fileinfo 
```

## Remove PHP restricted OS command
```bash
putenv
proc_open
symlink
```

## Installation
```bash
1.Create Database
2.Copy env.example to .env
3.Change database name and password in .env file
```
### Env
```bash
BACKEND_TITLE = "your backend title appear in browser tab bar"
DB_USERNAME = "your database username"
DB_PASSWORD ="your database password"
BACKEND_SUFIX ='your backend entry url sufix eg.http://url/sufix'
SESSION_LIFETIME = 'login user session expired time default is 1200second'
```

### Add the following to nginx config
```bash
add_header X-Frame-Options "SAMEORIGIN";
add_header X-Content-Type-Options "nosniff";
index index.php;
charset utf-8;
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
location = /favicon.ico { access_log off; log_not_found off; }
location = /robots.txt  { access_log off; log_not_found off; }
```

### Navigate to project directory
```bash
1.composer install
2.php artisan key:generate
3.php artisan storage:link
4.php artisan module:migrate --seed
5.composer install --optimize-autoloader --no-dev 
```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
