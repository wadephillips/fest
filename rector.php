<?php

use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Rector\Laravel\Set\LaravelSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // here we can define, what sets of rules will be applied
    // tip: use "SetList" class to autocomplete sets
    $containerConfigurator->import(LaravelSetList::LARAVEL_58);
    $containerConfigurator->import(LaravelSetList::LARAVEL_60);


};
