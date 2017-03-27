<?php
ob_start();

ini_set('display_errors', 1);
set_time_limit(0);

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__) . DS);
define('APP_PATH', 'app' . DS);
define('TEMPLATES_PATH', ROOT_PATH . 'templates' . DS);

define('HXPHP_VERSION', '2.6.4');

/**
 * Verifica se o autoload do Composer está configurado
 */
$composer_autoload = 'vendor' . DS . 'autoload.php';

if (!file_exists($composer_autoload))
    die('Execute o comando: composer install');

if (version_compare(PHP_VERSION, '5.4.0', '<'))
    die('Atualize seu PHP para a vers&atilde;o: 5.4.0 ou superior.');

require_once($composer_autoload);

//Start da sessão
HXPHP\System\Services\StartSession\StartSession::sec_session_start();

//Inicio da aplicação
$app = new HXPHP\System\App(require_once APP_PATH . 'config.php');
$app->ActiveRecord();
$app->run();