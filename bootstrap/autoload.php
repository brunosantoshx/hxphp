<?php

use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Verifica se o autoload do Composer está configurado
 */
$composer_autoload = dirname(__DIR__) . DS . 'vendor' . DS . 'autoload.php';

if (!file_exists($composer_autoload)) {
    die('Execute o comando: composer install');
}

if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    require_once('interface.php');

    die;
}

require_once($composer_autoload);

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$dotenv = new Dotenv(dirname(__DIR__));
$dotenv->load();

$request = Request::createFromGlobals();

$dispatcher = new EventDispatcher();

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$kernel = new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

$response = $kernel->handle($request);
$response->send();
