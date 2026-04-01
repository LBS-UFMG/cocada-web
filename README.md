# cocada-web
 
Contact database built based on analyses of the COCADA tool on data collected from the Protein Data Base (PDB).

## update 2025
COCADA-WEB and COCADA-DB were merged.

# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library


# Web tool

## Putting it into production (Apache Server)
In the terminal, access the Apache root directory:

`cd /var/www/html`

Clone the repository:

`git clone https://github.com/LBS-UFMG/cocada-web.git`

Access the newly created directory:

`cd cocada-web`

Install the libraries using composer:

`composer install`

Change the directory owner to Apache:
`sudo chown -R www-data:www-data *`

If necessary, delete the cache in the /writable/cache folder:
`cd writable/cache`

`rm -rf *`

Now let's configure the environment. Go back to the project root and make a copy of the `.env` file:

`cd /var/www/html/cocada-web`

`cp env .env`

Now edit the `.env` file:

`nano .env`

Remove the comments from the lines:

`CI_ENVIRONMENT = production`

`app.baseURL = 'http://bioinfo.dcc.ufmg.br/cocada-web/public'`

Press Ctrl+O and Ctrl+X

Check if the site is configured in Apache:

`sudo nano /etc/apache2/sites-available/000-default-le-ssl.conf`

Now check if the following line exists (press Ctrl+W and type 'cocada-web'):

`Alias ​​/rnapedia /var/www/html/cocada-web/public`

If it doesn't exist, add the line and save the file with Ctrl+O. Press Ctrl+X to exit.

Then restart Apache with the command:

`sudo service apache2 restart`

## About the data

The `/public/data` folder is not synchronized by GitHub. It contains two folders: `pdb` and `projects`. The `pdb` folder contains the contact files calculated by COCADA-CLI. The `projects` folder contains data calculated by the web interface.