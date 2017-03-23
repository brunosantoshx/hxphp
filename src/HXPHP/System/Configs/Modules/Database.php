<?php
namespace HXPHP\System\Configs\Modules;

class Database
{
    public $driver;
    public $host;
    public $user;
    public $password;
    public $dbname;
    public $charset;

    public function __construct()
    {
        $this->setConnectionData([
            'driver' => 'mysql',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'dbname' => 'hxphp',
            'charset' => 'utf8'
        ]);
        return $this;
    }

    public function setConnectionData(array $data)
    {
        foreach ($data as $param => $value) {

            if (!property_exists($this, $param))
                throw new \Exception("O parametro <$param> nao existe. Verifique a sintaxe e tente novamente", true);

            $this->$param = $value;
        }

        return $this;
    }
}