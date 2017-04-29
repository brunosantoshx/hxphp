<?php
namespace HXPHP\System\Configs\Modules;

class Mail
{
    public $from;
    public $from_mail;

    private $SMTP_configs = [];

    public function __construct()
    {
        $this->SMTP_configs = [
            'Host'       => null,
            'SMTPAuth'   => null,
            'Password'   => null,
            'Username'   => null,
            'SMTPSecure' => null,
            'Port'       => null
        ];

        $this->setFrom([
            'from' => 'HXPHP Framework',
            'from_mail' => 'no-reply@hxphp.com.br'
        ]);
    }

    public function setFrom(array $data): self
    {
        $this->from = $data['from'];
        $this->from_mail = $data['from_mail'];

        return $this;
    }

    public function setSMTP(array $data): self
    {
        if (!class_exists('PHPMailer'))
            throw new \Exception("Adicione o PHPMailer ao seu projeto com o comando: composer require phpmailer/phpmailer.", 1);

        $this->SMTP_configs = array_merge($this->SMTP_configs, $data);

        return $this;
    }

    public function getFrom(): array
    {
        return [
            'from_mail' => $this->from_mail,
            'from_name' => $this->from
        ];
    }
}