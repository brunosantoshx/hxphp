<?php
namespace HXPHP\System\Services\PasswordRecovery;

class PasswordRecovery
{
    /**
     * Link de redefinição
     * @var null
     */
    public $link = null;

    /**
     * Código alfanumérico de autenticação da requisição
     * @var string
     */
    public $token;

    /**
     * Define o link
     * @param string $link Prefixo do link c/ barra no final Ex.: http://www.site.com.br/esqueci-a-senha/redefinir/
     */
    public function __construct($link)
    {
        $this->setLink($link);
    }

    /**
     * Gera o token
     */
    private function generateToken()
    {
        $this->token = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
    }

    /**
     * Define o link
     * @param string $link Prefixo do link c/ barra no final
     */
    public function setLink($link)
    {
        $this->generateToken();
        $this->link = $link . $this->token;
    }
}