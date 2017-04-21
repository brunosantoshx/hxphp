<?php
namespace HXPHP\System\Configs;

use HXPHP\System\Http\Request;

class DefineEnvironment
{
    private $currentEnviroment;

    public function __construct()
    {
        //Servidor atual
        $request = new Request();
        $server_name = $request->server('SERVER_NAME');

        //Estanciamento da pasta Environments
        $enviroments = new \FilesystemIterator(__DIR__ . '/Environments', \FilesystemIterator::SKIP_DOTS);

        //Carrega todos os arquivos da pasta Environments
        foreach ($enviroments as $environment) {
            //Recebe o nome de cada um sem a extensão .php
            $envName = $environment->getBasename('.php');

            //Atribuição do namespace
            $envClass = 'HXPHP\System\Configs\Environments\\' . $envName;

            //Verificação de segurança se a classe realmente existe
            if (class_exists($envClass)) {
                //Estanciamento da classe environment
                $env = new $envClass;

                //Verificação se ambiente atual é o do env estanciado
                if (in_array($server_name, $env->servers)) {
                    //Separação camelCase de Environment{Foo}
                    $currentEnv = preg_split('/(?=[A-Z])/', $envName);

                    //Atribuição
                    $currentEnv = strtolower($currentEnv[2]);
                    $this->currentEnviroment = $currentEnv;

                    //Saída do loop de repetição para ganho de tempo na aplicação
                    break;
                }
                else
                    continue;
            }
        }
    }

    public function setDefaultEnv(string $environment)
    {
        $env = new Environment;
        if (is_object($env->add($environment)))
            $this->currentEnviroment = $environment;
    }

    public function getDefault(): string
    {
        return $this->currentEnviroment;
    }
}

trait CurrentEnviroment
{
    public function getCurrentEnvironment(): string
    {
        $default = new DefineEnvironment;
        return $default->getDefault();
    }
}