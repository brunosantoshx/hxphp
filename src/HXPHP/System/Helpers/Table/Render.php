<?php
namespace HXPHP\System\Helpers\Table;

class Render
{
    //Armazena instância da tabela a ser renderizada
    private $table;
    
    /**
    * Injeção da tabela
    */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }
    
    /**
    * Renderiza o caption da tabela
    * @return string    HTML do caption
    */
    public function captionRender()
    {        
        return $this->table->getCaption();
    }
    
    /**
    * Renderiza o cabeçalho da tabela
    * @return string    HTML do cabeçalho
    */
    public function headerRender(): string
    {
        $attrs = implode(' ', $this->table->thead_attrs);
        
        $header = $this->table->getHeader();
        $header = implode('', $header);
        $header = sprintf($this->table->elements->get('tag_thead'), $attrs, $header);
        return $header;
    }
    
    /**
    * Renderiza o corpo da tabela
    * @return string    HTML do corpo da tabela
    */
    public function bodyRender(): string
    {
        $attrs = implode(' ', $this->table->tbody_attrs);
        
        $rows = $this->table->getRows();
        $rows = implode('', $rows);
        $rows = sprintf($this->table->elements->get('tag_tbody'), $attrs, $rows);
        return $rows;
    }
    
    /**
    * Renderiza o rodapé da tabela
    * @return string    HTML do rodapé
    */
    public function footerRender(): string
    {
        $attrs = implode(' ', $this->table->tfoot_attrs);
        
        $footer = $this->table->getFooter();
        $footer = implode('', $footer);
        $footer = sprintf($this->table->elements->get('tag_tfoot'), $attrs, $footer);
        return $footer;
    }
    
    /**
    * Une e renderiza a tabela
    * @return string    HTML da tabela
    */
    public function getHTML(): string
    {
        $table_attrs = implode(' ', $this->table->table_attrs);
        
        $caption = $this->captionRender();
        $header = $this->headerRender();
        $body = $this->bodyRender();
        $footer = $this->footerRender();
        
        $html = sprintf($this->table->elements->get('tag_table'), $table_attrs, $caption.$header.$body.$footer);
        
        return $html;        
    }    
}