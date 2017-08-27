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
    public function __construct(array $attributes = [], bool $guard_attributes = true, bool $instantiating_via_find = false, bool $new_record = true)
    {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    }
}