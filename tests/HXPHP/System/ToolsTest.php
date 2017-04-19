<?php

class ToolsTest extends \PHPUnit\Framework\TestCase
{
    public function testHashHXFunction()
    {
        $hash = HXPHP\System\Tools::hashHX('hxphp', 123);
        
        $this->assertEquals(123, $hash['salt']);
        $this->assertEquals('7e9e30557fededb50494168ee8960743a4a75e7102d8dd9a59bee5a7863ebb66288ad0fd73eff38b3239aa2dcc44aa0fa68492ccc4c2eccc69c11a34589741ad', $hash['password']);
    }

    public function testFilteredNameFunction()
    {
        $this->assertEquals(
            'HxPhp',
            HXPHP\System\Tools::filteredName('hx_php')
        );

        $this->assertEquals(
            'FrameworkPHP',
            HXPHP\System\Tools::filteredName('Framework_PHP')
        );
    }

    public function testFilteredFileNameFunction()
    {
        $this->assertEquals(
            'voce_esta_otimo_nos_tambem',
            HXPHP\System\Tools::filteredFileName('Você está ótimo & nós também')
        );
    }

    public function testDecamelizeFunction()
    {
        $this->assertEquals(
            'carro@breto@parado@na@porta',
            HXPHP\System\Tools::filteredFileName('CarroPretoParadoNaPorta', '@')
        );
    }
}
