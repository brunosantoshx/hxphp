<?php
namespace HXPHP\System\Helpers\Table;

class Table
{
    
    //$this->table->addRow(['1', 'Caio', '21 anos'], ['class' => 'primeira-linha']);
    
    //colocar como private!
    public $rows = [];
    /**
    * Adiciona uma linha à tabela
    * @param array $cells   Celulas da linha
    * @param array $attrs   Atributos da linha
    */
    public function addRow(array $cells, array $attrs = [])
    {
        $row = new Row('tr', $attrs);
        
        foreach ($cells as $cell)
            $row->addCell('td', $cell);
        
        $this->rows[] = $row->getHTML();
    }
    
    /**
    * Adiciona mais de uma linha à tabela
    * @param array $rows    Linhas a serem adicionadas à tabela
    * @param array $attrs   Atributos das linhas
    */
    public function addRows(array $rows, array $attrs = [])
    {
        foreach ($rows as $cells)
            $this->addRow($cells, $attrs);            
    }
}