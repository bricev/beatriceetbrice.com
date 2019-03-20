<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Wedding\Application\Http\Kernel as WeddingKernel;
use Wedding\Infrastructure\Services;

$services = Services::getInstance();

$services->stripe; // sets API key

$kernel = new WeddingKernel(
    $services->guestlist,
    $services->notebook
);

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
