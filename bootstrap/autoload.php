<?php

use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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

