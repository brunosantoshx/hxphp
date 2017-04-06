<?php
namespace HXPHP\System\Helpers\Alert;

class Render
{
    /**
     * Renderiza as mensagens
     * @param  array|string $messages Mensagem pode ser um array com a seguinte estrutura ['Erro' => 'Justicativa' , 'Erro 2' => 'Justificativa 2'] ou uma string
     * @return mixed
     */
    public function get($messages): string
    {
        if (!is_array($messages))
            return $messages;

        $html = '';

        foreach ($messages as $key => $message)
            $html .= '<li>' . $message . '</li>';


        return $html;
    }
}