<?php

use HXPHP\System\App;
use HXPHP\System\Services\StartSession\StartSession;

define('DS', DIRECTORY_SEPARATOR);
define('BOOTSTRAP_PATH', dirname(__FILE__) . DS . 'bootstrap' . DS);


require_once(BOOTSTRAP_PATH . 'autoload.php');
require_once(BOOTSTRAP_PATH . 'app.php');

//Start da sessão
StartSession::sec_session_start();

//Inicio da aplicação
$app = new App(require_once(APP_PATH . 'config.php'));
$app->ActiveRecord();
$app->run();
