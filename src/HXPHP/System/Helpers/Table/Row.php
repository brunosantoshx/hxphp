<?php
namespace HXPHP\System\Helpers\Table;

class Row
{
    private $cells = [];
    
    public function addCell(string $content, array $attrs = [])
    {
        $cell = new Cell($content, $attrs);
        $$this->cells[] = $cell->getHTML();
    }
}
   