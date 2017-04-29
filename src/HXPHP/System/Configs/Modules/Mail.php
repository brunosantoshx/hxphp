<?php
namespace HXPHP\System\Configs\Modules;

class Mail
{
    public $from;
    public $from_mail;

    /**
     * SMTP Credentials
     * @var string
     */
    public $Host;
    public $SMTPAuth;
    public $Username;
    public $Password;
    public $SMTPSecure;
    public $Port;

    public function __construct()
    {
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
            
        $this->Host = $data['Host'];
        $this->SMTPAuth = $data['SMTPAuth'];
        $this->Password = $data['Password'];
        $this->Username = $data['Username'];
        $this->SMTPSecure = $data['SMTPSecure'];
        $this->Port = $data['Port'];

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