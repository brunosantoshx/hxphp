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
        header("location: $url");

        exit();
    }

    public function header($header)
    {
        header($header);
    }
}
