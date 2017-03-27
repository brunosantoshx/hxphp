<?php

header("HTTP/1.0 404 Not Found");

class Error404Controller extends \HXPHP\System\Controller
{
    public function indexAction()
    {
        /**
         * Esta configuração evita a necessidade de duplicar
         * a pasta "app/views/error404" para "app/views/admin/error404".
         *
         * Isto ocorre porque os métodos de manipulação da view são apontados
         * para a raiz da pasta "app/views/".
         */
        $this->view->setHeader('header')
                ->setPath('error404')
                ->setFooter('footer')
                ->setAssets('css', $this->configs->baseURI . 'public/css/error.css');
    }
}