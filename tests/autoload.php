<?php

$testEnvironment = 'testing';

require_once __DIR__ . '/../vendor/autoload.php';

Patchwork\Utf8\Bootup::initMbstring();
Illuminate\Support\ClassLoader::register();
