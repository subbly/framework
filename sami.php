<?php

use Sami\Sami;
use Sami\Version\GitVersionCollection;

use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->path('Subbly')
    ->in($dir = __DIR__ . '/src/')
;

$versions = GitVersionCollection::create($dir)
    ->addFromTags('v0.1.*')
    ->add('master', 'master branch')
;

return new Sami($iterator, array(
    // 'theme'                => 'default',
    'versions'             => $versions,
    'title'                => 'Subbly API',
    'build_dir'            => __DIR__.'/build/%version%',
    'cache_dir'            => __DIR__.'/cache/%version%',
    'default_opened_level' => 2,
    'include_parent_data'  => true,
));
