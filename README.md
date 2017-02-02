# Laravel PHP OPcache tools #

A great tool to clear the PHP OPcache in a Laravel application. We're also working to make this tool available without Laravel and other packages.

### Why would I use Laravel PHP OPcache tools? ###

Some hosting providers don't give you the option to clear the OPcache. This could cause issues with your website after a deploy. With Laravel PHP OPcache it's possible to clear the cache without php restart permissions.

### Installation? ###

You can easily install Laravel PHP OPcache with Composer:

```
#!bash

composer require frewillems/laravel-opcache
```

Also configure the service provider in your app config

```
#!php

// config/app.php
'providers' => [
    ...
    FreWillems\OPCache\OPCacheServiceProvider::class,
]
```

And make sure you have configured the correct APP_URL in your config.

### How to use? ###

After you have installed this package the usage is straight forward. Just run the following command in your project root:


```
#!bash

php artisan opcache:clear
```

### Who do I talk to? ###

* Repo owner or admin