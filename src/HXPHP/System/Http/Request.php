<?php

namespace HXPHP\System\Http;

use HXPHP\System\Tools;

class Request
{

	/**
	 * Atributos
	 * @var null
	 */
	public  $subfolder = '';
	public  $controller = 'IndexController';
	public  $action = 'indexAction';
	public  $params = [];

	/**
	 * Filtros customizados de tratamento
	 * @var array
	 */
	public $custom_filters = [];

	/**
	 * Método construtor
	 */
	public function __construct($baseURI = '', $controller_directory = '')
	{
		$this->subfolder = 'default';
		$this->initialize($baseURI, $controller_directory);
		return $this;
	}

	/**
	 * Define os parâmetros do mecanismo MVC
	 * @return object Retorna o objeto com as propriedades definidas
	 */
	public function initialize($baseURI, $controller_directory)
	{
		if ( ! empty($baseURI) && ! empty($controller_directory)) {
			$explode = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));

			$baseURICount = count(array_filter(explode('/', $baseURI)));

			if (count($explode) == $baseURICount)
				return $this;

			if (count($explode) != $baseURICount){

				for($i=0; $i < $baseURICount; $i++) { 
					unset($explode[$i]);
				}

				$explode = array_values($explode);

			}
			
			if (file_exists($controller_directory . $explode[0])) {

				//ADICIONADA POSSIBILIDADE DE ADICIONAR MAIS DE UM SUBFOLDER
				if(isset($explode[1]) && file_exists($controller_directory . $explode[0] ."\\". $explode[1])){
					$this->subfolder = $explode[0] ."\\". $explode[1];

					if (isset($explode[2]))
					$this->controller = Tools::filteredName($explode[2]).'Controller';
	
					if (isset($explode[3])) {
						$this->action = lcfirst(Tools::filteredName($explode[3])).'Action';
	
						unset($explode[3]);
					}

				}else{

					$this->subfolder = $explode[0];
					if (isset($explode[1]))
					$this->controller = Tools::filteredName($explode[1]).'Controller';
	
					if (isset($explode[2])) {
						$this->action = lcfirst(Tools::filteredName($explode[2])).'Action';
	
						unset($explode[2]);
					}

				}
				
			}
			elseif (count($explode) == 1) {
				$this->controller = Tools::filteredName($explode[0]).'Controller';

				return $this;
			}
			else {
				$this->controller = Tools::filteredName($explode[0]).'Controller';
				$this->action = lcfirst(Tools::filteredName($explode[1])).'Action';
			}
			if(isset($explode[1]) && file_exists($controller_directory . $explode[0] ."\\". $explode[1])){
				unset($explode[0], $explode[1], $explode[2] );
			}else{
				unset($explode[0], $explode[1]);
			}
			
			
			$this->params = array_values($explode);
		}
	}

	/**
	 * Define filtros/flags customizados (http://php.net/manual/en/filter.filters.sanitize.php)
	 * @param array $custom_filters Array com nome do campo e seu respectivo filtro
	 */
	public function setCustomFilters(array $custom_filters = [])
	{
		return $this->custom_filters = $custom_filters;
	}

	/**
	 * Realiza o tratamento das super globais
	 * @param  array $request 		  Array nativo com campos e valores passados
	 * @param  const $data    		  Constante que será tratada
	 * @param  array $custom_filters  Filtros customizados para determinados campos
	 * @return array                  Constate tratada
	 */
	public function filter(array $request, $data, array $custom_filters = [])
	{
		$filters = [];

		foreach ($request as $key => $value)
			if (!array_key_exists($key, $custom_filters))
				$filters[$key] = constant('FILTER_SANITIZE_STRING');



		if (is_array($custom_filters) && is_array($custom_filters))
			$filters = array_merge($filters,$custom_filters);

		return filter_input_array($data, $filters);
	}

	/**
	 * Obtém os dados enviados através do método GET
	 * @param  string $name Nome do parâmetro
	 * @return null         Retorna o array GET geral ou em um índice específico
	 */
	public function get($name = null)
	{
		$get = $this->filter($_GET, INPUT_GET, $this->custom_filters);

		if (!$name)
			return $get;


		if (!isset($get[$name]))
			return null;


		return $get[$name];
	}

	/**
	 * Obtém os dados enviados através do método POST
	 * @param  string $name Nome do parâmetro
	 * @return null         Retorna o array POST geral ou em um índice específico
	 */
	public function post($name = null)
	{
		$post = $this->filter($_POST, INPUT_POST, $this->custom_filters);

		if (!$name)
			return $post;

		if (!isset($post[$name]))
			return null;


		return $post[$name];
	}

    /**
	 * Obtém os dados da superglobal $_SERVER
	 * @param  string $name Nome do parâmetro
	 * @return null         Retorna o array $_SERVER geral ou em um índice específico
	 */
    public function server($name = null)
    {
        $server = $this->filter($_SERVER, INPUT_SERVER, $this->custom_filters);

        if(!$name)
            return $server;

        if(!isset($server[$name]) && !isset($_SERVER[$name]))
            return NULL;

        if (isset($_SERVER[$name]))
        	return $_SERVER[$name];

        return $server[$name];
    }
    
    /**
     * Obtém os dados da superglobal $_COOKIE
     * @param string $name Nome do parâmetro
     * @return null Retorna o array $_COOKIE geral ou em um índice específico
     */
    public function cookie($name = null)
    {
        $cookie = $this->filter($_COOKIE, INPUT_COOKIE, $this->custom_filters);
    
        if(!$name)
             return $cookie;
    
        if(!isset($cookie[$name]))
             return NULL;
    
        return $cookie[$name];
    }

	/**
	 * Retorna o método da requisição
	 * @param  string $value Nome do método
	 * @return null          Retorna um booleano ou o método em si
	 */
	public function getMethod($value = null)
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if ($value)
			return $method == $value;


		return $method;
	}

	/**
	 * Verifica se o método da requisição é POST
	 * @return boolean Status da verificação
	 */
	public function isPost()
	{
		return $this->getMethod('POST');
	}

	/**
	 * Verifica se o método da requisição é GET
	 * @return boolean Status da verificação
	 */
	public function isGet()
	{
		return $this->getMethod('GET');
	}

	/**
	 * Verifica se o método da requisição é PUT
	 * @return boolean Status da verificação
	 */
	public function isPut()
	{
		return $this->getMethod('PUT');
	}

	/**
	 * Verifica se o método da requisição é HEAD
	 * @return boolean Status da verificação
	 */
	public function isHead()
	{
		return $this->getMethod('HEAD');
	}


    /*
     * Verifica se os inputs no método requisitado estão no formato correto conforme o array informado $custom_filters
     *
     * @return boolean Inputs estão corretos ou não
     */
    public function isValid()
    {
        $method = $this->getMethod();

        return array_search(false, $this->$method(), true) === false ? true : false;
    }
}
