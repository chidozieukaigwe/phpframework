<?php

use App\Provider\EventServiceProvider;

$providers = [
    EventServiceProvider::class
];

foreach($providers as $providerClass)
{
    $provider = $container->get($providerClass);
    $provider->register();
}