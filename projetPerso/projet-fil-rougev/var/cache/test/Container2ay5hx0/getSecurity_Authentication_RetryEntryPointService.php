<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'security.authentication.retry_entry_point' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/security-http/EntryPoint/AuthenticationEntryPointInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/EntryPoint/RetryAuthenticationEntryPoint.php';

return $this->privates['security.authentication.retry_entry_point'] = new \Symfony\Component\Security\Http\EntryPoint\RetryAuthenticationEntryPoint(80, 443);
