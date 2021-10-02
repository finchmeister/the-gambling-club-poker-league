<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;


if (isset($_ENV['HIDE_APP_DEV'])) {
    header('HTTP/1.0 403 Forbidden');
    exit('Disabled in Production');
}

require __DIR__.'/../vendor/autoload.php';
Debug::enable();

$kernel = new AppKernel('dev', true);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
