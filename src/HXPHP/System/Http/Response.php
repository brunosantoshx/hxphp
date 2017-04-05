<?php
namespace HXPHP\System\Http;

class Response
{

    /**
     * Redirecionamento
     * @param  string $url URL para aonde a aplicação deve ser redirecionada
     */
    public function redirectTo(string $url)
    {
        $this->header('location: ' . $url);

        exit();
    }

    public function header(string $header)
    {
        header($header);
    }

}