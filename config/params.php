<?php
$experiments = require(__DIR__ . '/experiments.php');
$users = require(__DIR__ . '/users.php');

return [
    'adminEmail' => 'admin@example.com',
    'experiments' => $experiments,
    'users' => $users
];
