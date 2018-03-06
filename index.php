<?php
ob_start();

ini_set('display_errors', 1);
set_time_limit(0);

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

define('DS', DIRECTORY_SEPARATOR);

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__FILE__));
}

define('APP_PATH', 'app' . DS);

/**
 * Verifica se o autoload do Composer está configurado
 */
$composer_autoload = 'vendor' . DS . 'autoload.php';

if (!file_exists($composer_autoload))
    die('Execute o comando: composer install');

if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    require_once('interface.php');

    die;
 }

require_once($composer_autoload);

//Start da sessão
HXPHP\System\Services\StartSession\StartSession::sec_session_start();

//Inicio da aplicação
$app = new HXPHP\System\App(require_once APP_PATH . 'config.php');
$app->ActiveRecord();
$app->run();

