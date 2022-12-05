
## About Epic Movie Quotes

 

Epic Movie Quotes is a Laravel/Vue based social platform, where the users have the ability to post their favorite movie quotes and interact with each other using features as liking or commenting on each others posts.
By doing so, they send realtime notifications to the authors of the post to notify them about their activity. Users can also modify their posted quotes or even their list of movies, they're able to update and delete any item that they wish to modify. 

#
### Table of Contents

* [Prerequisites](#prerequisites)
* [Tech Stack](#tech-stack)
* [Getting Started](#getting-started)
* [Database Design Diagram](#database-design-diagram)

#

## Prerequisites

* <img src="readme/assets/php.svg" width="35" style="position: relative; top: 4px" /> *PHP@8.0.2 and up*
* <img src="readme/assets/mysql.png" width="35" style="position: relative; top: 4px" /> *MYSQL@8.0.30 and up*
* <img src="readme/assets/npm.png" width="35" style="position: relative; top: 4px" /> *npm@6.14.17 and up*
* <img src="readme/assets/composer.png" width="35" style="position: relative; top: 6px" /> *composer@2 and up*

#

## Tech stack
* <img src="readme/assets/laravel.png" width="35" style="position: relative; top: 4px" /> - back-end framework
* <img src="readme/assets/pusher.png" width="35" style="position: relative; top: 4px" /> - realtime notifications

#

## Getting Started

1\. First of all you need to clone Epic Movie Quotes  repository from github:
```sh
git clone https://github.com/RedberryInternship/epic-movie-quotes-api-nika-mamaladze
```

2\. Next step requires you to run *composer install* in order to install all the dependencies.
```sh
composer install
```


3\. after you have installed all the PHP dependencies, it's time to install all the JS dependencies:
```sh
npm install
```

and also:
```sh
npm run dev
```

In order to run Vite

4\. Now we need to set our env file. Go to the root of your project and execute this command.
```sh
cp .env.example .env
```
And now you should provide **.env** file all the necessary environment variables:

#
**MYSQL:**
>DB_CONNECTION=mysql
>DB_HOST=127.0.0.1
>DB_PORT=3306
>DB_DATABASE=*****
>DB_USERNAME=*****
>DB_PASSWORD=*****

after setting up **.env** file, execute:
```sh
 php artisan config:cache
```
in order to cache environment variables.

5\. Now execute in the root of you project following:
```sh
  php artisan key:generate
```
Which generates auth key.

## Now, you should be good to go!

#
### Migration
if you've completed getting started section, then migrating database if fairly simple process, just execute:
```sh
 php artisan migrate
```
#
### Development

You can run Laravel's built-in development server by executing:

```sh
 php artisan serve
```

### Database Design Diagram

[Database Design Diagram](./readme/uml/uml.md "Draw.io")
