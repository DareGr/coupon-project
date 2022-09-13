[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]

# Coupon Generator

Generate all types of coupons for your application.

### Built With

* [![Laravel][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]


## Installation

Make a new folder at your local machine. Inside that folder open CLI or Git Bash and run following git command.

```bash
git clone https://github.com/DareGr/coupon-project.git
```
In your CLI or Git Bash, enter the root of folder where your project has been created.

Run following command.

```bash
composer install
```
After successfully composer installation run following command.

```bash
composer update
```

## Run app

Before you run project you must edit env variables inside .env file.

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR DB NAME
DB_USERNAME=YOUR DB USERNAME
DB_PASSWORD=YOUR DB PASSWORD
```
If you don't have npm, you must install it. 

```bash
npm install
```
And after that, inside your project folder you must run following command. 

```bash
npm run dev
```

Finally to start project run:

```bash
php artisan serve
```
Project should be serverd on http://localhost:8000


## Running migration and seeders

To run migrations and seeders for you database, run following command.

```bash
php artisan migrate:refresh --seed 
```
## Credentials for login

```bash
email: admintest@gmail.com
password: admintest
```

If you want to register more users, you must uncomment register code inside app/config/fortify.php

```bash
// Features::registration(),
```


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/github_username/repo_name.svg?style=for-the-badge
[contributors-url]: https://github.com/github_username/repo_name/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/github_username/repo_name.svg?style=for-the-badge
[forks-url]: https://github.com/github_username/repo_name/network/members
[stars-shield]: https://img.shields.io/github/stars/github_username/repo_name.svg?style=for-the-badge
[stars-url]: https://github.com/github_username/repo_name/stargazers


[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com

