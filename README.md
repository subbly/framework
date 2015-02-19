Subbly Framework
===

[![Build Status](https://travis-ci.org/subbly/framework.svg)](https://travis-ci.org/subbly/framework)
[![Total Downloads](https://poser.pugx.org/subbly/framework/downloads.svg)](https://packagist.org/packages/subbly/framework)
[![Latest Stable Version](https://poser.pugx.org/subbly/framework/v/stable.svg)](https://packagist.org/packages/subbly/framework)
[![Latest Unstable Version](https://poser.pugx.org/subbly/framework/v/unstable.svg)](https://packagist.org/packages/subbly/framework)
[![License](https://poser.pugx.org/subbly/framework/license.svg)](https://packagist.org/packages/subbly/framework)

## DB schemas

### Add a new migration

    $ php artisan migrate:make create_gateway_token_table --path=vendor/subbly/framework/src/migrations/  

Where `create_gateway_token_table` is the description of the migration.  

### Run migration

    $ php artisan migrate --path=vendor/subbly/framework/src/migrations/  


