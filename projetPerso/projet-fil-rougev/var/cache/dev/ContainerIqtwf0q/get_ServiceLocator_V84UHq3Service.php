<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.V84UHq3' shared service.

return $this->privates['.service_locator.V84UHq3'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
    'partenaire' => ['privates', '.errored..service_locator.V84UHq3.App\\Entity\\Partenaires', NULL, 'Cannot autowire service ".service_locator.V84UHq3": it references class "App\\Entity\\Partenaires" but no such service exists.'],
    'serializer' => ['services', 'serializer', 'getSerializerService', false],
    'validator' => ['services', 'validator', 'getValidatorService', false],
], [
    'entityManager' => '?',
    'partenaire' => 'App\\Entity\\Partenaires',
    'serializer' => '?',
    'validator' => '?',
]);
