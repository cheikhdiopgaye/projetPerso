<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'fos_rest.access_denied_listener' shared service.

include_once $this->targetDirs[3].'/vendor/friendsofsymfony/rest-bundle/EventListener/AccessDeniedListener.php';

return $this->privates['fos_rest.access_denied_listener'] = new \FOS\RestBundle\EventListener\AccessDeniedListener(['json' => true], NULL);
