AlBERTO
=======

AraBidopsis EmbRyonic Transcriptome brOwser 

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
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
php composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta2"
~~~

Then install the dependencies as they are specified in the composer.lock file:

~~~
php composer.phar install
~~~

Now you should be able to access the application through the following URL, assuming `alberto` is the directory
directly under the Web root.

~~~
http://localhost/alberto
~~~

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Also check and edit the other files in the `config/` directory to customize your application.

Copyright and licence
---------------------

Code is copyright of (c) 2014 Wageningen University and released under the GNU GPL v2 license.
