<?php
namespace HXPHP\System\Services\Email;

class Email
{
    private $from = null;

    public function setFrom(array $from = []): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Envia e-mail
     * @param  string $to    E-mail para qual será enviada a mensagem
     * @param  string $assunto  Assunto da mensagem
     * @param  string $message Mensagem
     * @param  array  $from   Array com Remetente e E-mail do remetente
     * @param  bool   $accept_html Define se a mensagem será enviada em TXT ou HTML
     * @return bool             Status de envio e mensagem
     */
    public function send(string $to, string $subject, string $message, array $from = [], bool $accept_html = true): bool
    {
        $to = strtolower($to);
        $subject = addslashes(trim($subject));

        $message = !($accept_html) ? strip_tags($message) : $message;
        $message = nl2br($message);

        $from = ($this->from) && !($from) ? $this->from : $from;

        ksort($from);
        $from = array_values($from);

        list($from_mail, $from_name) = $from;

        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\n";
        $headers .= "From: \"{$from_name}\" <{$from_mail}>\n";

        return @mail($to, $subject, $message, $headers);
    }
}