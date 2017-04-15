<?php
namespace HXPHP\System\Helpers\Table;

class Table
{
    private $rows = [];
    
    public $header = [];
    
    private $footer = [];
    
    private $caption_attrs = []; 
    
    private $caption_content;
    
    private $table_attrs = [];
    
    /**
    * Adiciona uma linha à tabela
    * @param array $cells   Celulas da linha
    * @param array $attrs   Atributos da linha
    */
    public function addRow(array $cells, array $attrs = [])
    {
        $row = new Row($attrs);
        
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
    
    /**
    * Retorna as linhas do corpo da tabela
    * @return array Atributo $rows desta classe
    */
    public function getRows(): array
    {
        return $this->rows;
    }
    
    /*
    * Adiciona linha de cabeçalho
    * @param $cells         Celulas do cabeçalho
    * @param array $attrs   Atributos da linha
    */
    public function addHeader(array $cells, $attrs = [])
    {
        $row = new Row($attrs);
        
        foreach ($cells as $cell)
            $row->addCell('th', $cell);
        
        $this->header[] = $row->getHTML();
    }
    
    /**
    * Retorna as linhas do cabeçalho da tabela
    * @return array Atributo $header desta classe
    */
    public function getHeader(): array
    {
        return $this->header;
    }
    
    /*
    * Adiciona linha de rodapé
    * @param $cells         Celulas do rodapé
    * @param array $attrs   Atributos da linha
    */
    public function addFooter(array $cells, $attrs = [])
    {
        $row = new Row($attrs);
        
        foreach ($cells as $cell)
            $row->addCell('th', $cell);
        
        $this->footer[] = $row->getHTML();
    }
    
    /**
    * Retorna as linhas do rodapé da tabela
    * @return array Atributo $footer desta classe
    */
    public function getFooter(): array
    {
        return $this->footer;
    }
    
    /**
    * Adiciona caption à tabela
    * @param string $content    Conteúdo do caption
    * @param array $attrs       Atributos da tag caption
    */
    public function addCaption(string $content, array $attrs = [])
    {
        if ($attrs)
            foreach ($attrs as $attr => $value)
                $this->caption_attrs[] = ''.$attr.'="'.$value.'"';
        
        $this->caption_content = $content;
    }
    
    /**
    * Seta atributo para a tag <table>
    */
    public function addAttr(string $attr, string $value)
    {
        $this->table_attrs[] = $attr.'="'.$value.'"';
    }
    
    /**
    * Seta mais de 1 atributo para a tag <table>
    */
    public function addAttrs(array $attrs)
    {
        foreach ($attrs as $attr => $value)
            $this->addAttr($attr, $value);
    }
    
    
}