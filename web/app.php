<?php

use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';
include_once __DIR__.'/../var/bootstrap.php.cache';

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$kernelManager = new KernelManager('prod', false);
$kernel = $kernelManager->createKernelFromRequest($request);
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
