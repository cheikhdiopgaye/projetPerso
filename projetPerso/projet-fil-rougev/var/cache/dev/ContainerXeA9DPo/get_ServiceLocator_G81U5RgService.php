<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.G81U5Rg' shared service.

return $this->privates['.service_locator.G81U5Rg'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'depotRepository' => ['privates', 'App\\Repository\\DepotRepository', 'getDepotRepositoryService.php', true],
    'serializer' => ['services', 'serializer', 'getSerializerService', false],
], [
    'depotRepository' => 'App\\Repository\\DepotRepository',
    'serializer' => '?',
]);
