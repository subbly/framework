<?php

define('SUBBLY_TEST_ENV', TRUE);

function mkdir_if_not_exists($dir) {
    return is_dir($dir) or mkdir($dir);
}

mkdir_if_not_exists(__DIR__.'/dummy');
mkdir_if_not_exists(__DIR__.'/dummy/themes');
mkdir_if_not_exists(__DIR__.'/dummy/storage');
mkdir_if_not_exists(__DIR__.'/dummy/storage/cache');
mkdir_if_not_exists(__DIR__.'/dummy/storage/meta');
mkdir_if_not_exists(__DIR__.'/dummy/storage/sessions');

$testEnvironment = 'testing';

$config = require("app/config/{$testEnvironment}/database.php");

extract($config['connections'][$config['default']]);

$connection = new \PDO("{$driver}:host={$host}", $username, $password);
$connection->query("DROP DATABASE IF EXISTS ".$database);
$connection->query("CREATE DATABASE ".$database);
require_once __DIR__ . '/../vendor/autoload.php';

Patchwork\Utf8\Bootup::initMbstring();
Illuminate\Support\ClassLoader::register();
