<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
// use Lulucode\Database;

$env = new DotEnv(__DIR__);
$env->load();

// $dbConnection = (new Database())->connect();