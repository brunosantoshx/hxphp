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

define('HXPHP_VERSION', '3.0.0-rc.4');

/**
 * Verifica se o autoload do Composer está configurado
 */
$composer_autoload = 'vendor' . DS . 'autoload.php';

if (!file_exists($composer_autoload))
    die('Execute o comando: composer install');

if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    die('
    	<h2>
    		O suporte ao PHP 5 terminou e o reposit&oacute;rio agora encontra-se 
    		compat&iacute;vel com o PHP 7. 
    	</h2>
    	<h3>
    		Para continuar com PHP 5 use: 
    		<a href="https://github.com/brunosantoshx/hxphp/releases/tag/v2.18.14">
    			https://github.com/brunosantoshx/hxphp/releases/tag/v2.18.14
    		</a>
    		ou atualize seu PHP para a vers&atilde;o: 7.0.0 ou superior.
    	</h3>
    	<h3>
			Se você optar por atualizar o PHP lembre-se de atualizar todas as depend&ecirc;ncias atrav&eacute;s do Composer.
    	</h3>
    ');
 }

require_once($composer_autoload);

//Start da sessão
HXPHP\System\Services\StartSession\StartSession::sec_session_start();

//Inicio da aplicação
$app = new HXPHP\System\App(require_once APP_PATH . 'config.php');
$app->ActiveRecord();
$app->run();