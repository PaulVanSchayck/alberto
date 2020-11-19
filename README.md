AlBERTO
=======

AraBidopsis EmbRyonic Transcriptome brOwser 

**Online version:** http://www.albertodb.org

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0, and MySQL 5.x.


INSTALLATION
------------

### Download or clone the code

Download the latest version of the code [directly](https://github.com/PaulVanSchayck/alberto/archive/master.zip) or clone
it using git:

~~~
git clone https://github.com/PaulVanSchayck/alberto.git
~~~

### Install dependencies via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You need to install the composer-asset-plugin that Yii2 requires:

~~~
php composer.phar global require "fxp/composer-asset-plugin:1.1.*"
~~~

Then install the dependencies as they are specified in the composer.lock file:

~~~
php composer.phar install
~~~

Now you should be able to access the application through the following URL, assuming `alberto` is the directory
directly under the Web root.

~~~
http://localhost/alberto/web
~~~

CONFIGURATION
-------------

### Database

Copy the file `config/db.sample.php` to `config/db.php` and fill it with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=alberto',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

### Constructing and filling the database

Refer to the `data/README.md`

### Users

Copy the file `config/users.sample.php` to `config/users.php` and fill it.

Deployment
----------
In `deployment/update.sh` a simple deployment scrips is included which will first compress and
minify all JS and CSS files and then perform a lftp mirror. For this uglifyjs and cleancss are
required. These are node.js packages. Install through:

```
sudo npm install uglify-js -g
sudo npm install clean-css -g
```

Author
------

AlBERTO has been programmed by Paul van Schayck with feedback from Joakim Palovaara.


Copyright and licence
---------------------

Code is copyright of (c) 2014 Wageningen University and licensed under the GNU GPL v2 license.

SVG images are copyright of (c) 2014 Wageningen University and licensed under the [Creative Commons 
Attribution-ShareAlike 4.0 International License](http://creativecommons.org/licenses/by-sa/4.0/).