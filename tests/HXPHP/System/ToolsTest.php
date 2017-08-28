<?php

namespace Tests\System;

use HXPHP\System\Tools;
use Tests\BaseTestCase;

final class ToolsTest extends BaseTestCase
{
    public function testHashHXFunction(): void
    {
        $hash = Tools::hashHX('hxphp', 123);

        $this->assertEquals(123, $hash['salt']);
        $this->assertEquals(
            '7e9e30557fededb50494168ee8960743a4a75e7102d8dd9a59bee5a7863ebb66288ad0fd73eff38b3239aa2dcc44aa0fa68492ccc4c2eccc69c11a34589741ad',
            $hash['password']
        );
    }

    public function testFilteredNameFunction(): void
    {
        $this->assertEquals(
            'HxPhp',
            Tools::filteredName('hx_php')
        );

        $this->assertEquals(
            'FrameworkPHP',
            Tools::filteredName('Framework_PHP')
        );
    }

    public function testFilteredFileNameFunction(): void
    {
        $this->assertEquals(
            'voce_esta_otimo_&_nos_tambem',
            Tools::filteredFileName('Você está ótimo & nós também')
        );
    }

    public function testDecamelizeFunction(): void
    {
        $this->assertEquals(
            'carropretoparadonaporta',
            Tools::filteredFileName('CarroPretoParadoNaPorta', '@')
        );
    }
}
