<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'fos_rest.routing.loader.xml_collection' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/config/Loader/LoaderInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/config/Loader/Loader.php';
include_once $this->targetDirs[3].'/vendor/symfony/config/Loader/FileLoader.php';
include_once $this->targetDirs[3].'/vendor/symfony/routing/Loader/XmlFileLoader.php';
include_once $this->targetDirs[3].'/vendor/friendsofsymfony/rest-bundle/Routing/Loader/RestXmlCollectionLoader.php';
include_once $this->targetDirs[3].'/vendor/symfony/config/FileLocatorInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/config/FileLocator.php';
include_once $this->targetDirs[3].'/vendor/symfony/http-kernel/Config/FileLocator.php';
include_once $this->targetDirs[3].'/vendor/friendsofsymfony/rest-bundle/Routing/Loader/RestRouteProcessor.php';

return $this->privates['fos_rest.routing.loader.xml_collection'] = new \FOS\RestBundle\Routing\Loader\RestXmlCollectionLoader(($this->privates['file_locator'] ?? ($this->privates['file_locator'] = new \Symfony\Component\HttpKernel\Config\FileLocator(($this->services['kernel'] ?? $this->get('kernel', 1)), ($this->targetDirs[3].'/src/Resources'), [0 => ($this->targetDirs[3].'/src')]))), ($this->privates['fos_rest.routing.loader.processor'] ?? ($this->privates['fos_rest.routing.loader.processor'] = new \FOS\RestBundle\Routing\Loader\RestRouteProcessor())), false, ['json' => false, 'html' => true], 'json');
