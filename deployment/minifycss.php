#!/usr/bin/env php
<?php
require(__DIR__ . '/../vendor/autoload.php');

use MatthiasMullie\Minify;


$minifier = new Minify\CSS($argv[1]);
$minifier->minify($argv[2]);

