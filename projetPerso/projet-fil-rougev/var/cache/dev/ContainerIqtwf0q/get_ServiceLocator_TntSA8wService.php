<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.tntSA8w' shared service.

return $this->privates['.service_locator.tntSA8w'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'partRepository' => ['privates', 'App\\Repository\\PartenairesRepository', 'getPartenairesRepositoryService.php', true],
    'serializer' => ['services', 'serializer', 'getSerializerService', false],
], [
    'partRepository' => 'App\\Repository\\PartenairesRepository',
    'serializer' => '?',
]);
