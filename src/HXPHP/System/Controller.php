<?php

namespace HXPHP\System;
use HXPHP\System\Http as Http;

class Controller
{
	/**
	 * Injeção das Configurações
	 * @var object
	 */
	public $configs = null;

	/**
	 * Injeção do Http Request
	 * @var object
	 */
	private $request;

	/**
	 * Injeção do Http Response
	 * @var object
	 */
	private $response;

	/**
	 * Injeção da View
	 * @var object
	 */
	public $view;

	public function __construct($configs = null)
	{
		//Injeção da VIEW
		$this->view = new View;
		$this->response = new Http\Response;

		if ($configs && $configs instanceof Configs\Config)
			$this->setConfigs($configs);
	}

	/**
	 * Injeta as configurações
	 * @param  Config $configs Objeto com as configurações da aplicação
	 * @return object
	 */
	public function setConfigs(Configs\Config $configs)
	{
		//Injeção das dependências
		$this->configs  = $configs;
		$this->request  = new Http\Request($configs->baseURI, $configs->controllers->directory);

		return $this;
	}

	/**
	 * Default Action
	 */
	public function indexAction()
    {

    }

	/**
	 * Carrega serviços, módulos e helpers
	 * @param  string $object Nome da classe
	 * @param  string|array  $params Parâmetros do método construtor
	 * @return object         Objeto injetado
	 */
	public function load()
	{
		$total_args = func_num_args();

		if (!$total_args)
			throw new \Exception("Nenhum objeto foi definido para ser carregado.", 1);


		/**
		 * Retorna todos os argumentos e define o primeiro como
		 * o objeto que será injetado
		 * @var array
		 */
		$args = func_get_args();
		$object = $args[0];

		/**
		 * Define os demais argumentos passados como
		 * parâmetros para o construtor do objeto injetado
		 */
		unset($args[0]);
		$params = !($args) ? [] : array_values($args);

		/**
		 * Tratamento que adiciona a pasta do módulo
		 */
		$explode = explode('\\', $object);
		$object = $object . '\\' . end($explode);
		$object = 'HXPHP\System\\' . $object;

		if (class_exists($object)) {
			$name = end($explode);
			$name = strtolower(Tools::filteredName($name));

			if ($params) {
				$ref = new \ReflectionClass($object);
  				$this->view->$name = $ref->newInstanceArgs($params);
			}
			else
				$this->view->$name = new $object();


			return $this->view->$name;
		}
	}

	/**
	 * Método mágico para atalho de objetos injetados na VIEW
	 * @param  string $param Atributo
	 * @return mixed         Conteúdo do atributo ou Exception
	 */
	public function __get($param)
	{
		if (isset($this->view->$param))
			return $this->view->$param;

		elseif (isset($this->$param))
			return $this->$param;

		else
			throw new \Exception("Parametro <$param> nao encontrado.", 1);
	}

	/**
	 * Redirecionamento
	 * @param  string $url Link de redirecionamento
	 */
	public function redirectTo($url)
	{
		return $this->response->redirectTo($url);
	}
}