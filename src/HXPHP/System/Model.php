<?php
namespace HXPHP\System;

class Model extends \ActiveRecord\Model
{
    /**
     * Método construtor
     * @param array   $attributes             Atributo obrigatório do PHP ActiveRecord
     * @param boolean $guard_attributes       Atributo obrigatório do PHP ActiveRecord
     * @param boolean $instantiating_via_find Atributo obrigatório do PHP ActiveRecord
     * @param boolean $new_record             Atributo obrigatório do PHP ActiveRecord
     */
    public function __construct($attributes = [], $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE)
    {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);

        return $this;
    }
}