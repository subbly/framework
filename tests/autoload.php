<?php

define('SUBBLY_TEST_ENV', TRUE);

mkdir(__DIR__.'/dummy');
mkdir(__DIR__.'/dummy/themes');
mkdir(__DIR__.'/dummy/storage');
mkdir(__DIR__.'/dummy/storage/cache');
mkdir(__DIR__.'/dummy/storage/meta');
mkdir(__DIR__.'/dummy/storage/sessions');

$testEnvironment = 'testing';

require_once __DIR__ . '/../vendor/autoload.php';

Patchwork\Utf8\Bootup::initMbstring();
Illuminate\Support\ClassLoader::register();
