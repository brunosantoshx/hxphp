<?php
namespace HXPHP\System\Http;

class Response
{

    /**
     * Redirecionamento
     * @param  string $url URL para aonde a aplicação deve ser redirecionada
     */
    public function redirectTo($url)
    {
        $this->header('location: ' . $url);

        exit();
    }

    public function header($header)
    {
        header($header);
    }

}