<?php

namespace HXPHP\System\Configs\Modules;

class Mail
{
    public $from;
    public $from_mail;

    public function __construct()
    {
        $this->setFrom([
            'from' => 'HXPHP Framework',
            'from_mail' => 'no-reply@hxphp.com.br'
        ]);

        return $this;
    }

    public function setFrom(array $data): Mail
    {
        $this->from = $data['from'];
        $this->from_mail = $data['from_mail'];

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