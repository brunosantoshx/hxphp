<?php
namespace HXPHP\System\Helpers\Alert;

use HXPHP\System\Storage;

class Alert
{
    /**
     * Injeção do controle de sessão
     * @var object
     */
    private $storage;

    /**
     * Método construtor
     * @param array $alert ['Classe CSS', 'Título do alerta', 'Mensagem do alerta']
     */
    public function __construct(array $alert)
    {
        //Remoção dos índices associativos
        $alert = array_values($alert);

        //Injeção da Sessão
        $this->storage = new Storage\Session\Session;

        if (count($alert) === 0)
            return null;

        $alert[2] = $alert[2] ?? '';

        list($style, $title, $message) = $alert;

        /**
         * Rederiza a mensagem
         * @var string
         */
        $render = new Render();
        $render = $render->get($message);

        /**
         * Recupera o template html ara a mensagem
         * @var html
         */
        $template = new Template();
        $template = $template->get(is_array($message));

        /**
         * Aplica a mensagem no template
         * @var html
         */
        $content = sprintf($template, $style, $title, $render);

        $this->storage->set('message', $content);
    }

    /**
     * Retorna os alertas da aplicação
     * @return html
     */
    public function getAlert()
    {
        $message = $this->storage->get('message');
        $this->storage->clear('message');

        return $message;
    }

    /**
     * Retorna os alertas da aplicação
     * @return html
     */
    public function __toString()
    {
        return $this->getAlert();
    }
}