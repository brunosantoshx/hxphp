<?php
namespace HXPHP\System;

class View
{
    /**
     * Título da página
     * @var string
     */
    public $title = null;

    /**
     * Injeção das Configurações
     * @var object
     */
    private $configs;

    /**
     * Injeção do Http Request
     * @var object
     */
    private $request;

    /**
     * Parâmetros de configuração da VIEW
     * @var string
     */
    protected $partialsDir = null;
    public $subfolder = null;
    public $path = null;
    protected $template = null;
    protected $header = null;
    protected $file = null;
    protected $footer = null;
    protected $vars = [];
    protected $assets = [
        'css' => [],
        'js' => []
    ];

    public function setConfigs(Configs\Config $configs, string $subfolder, string $controller, string $action)
    {
        /**
         * Injeção das Configurações
         * @var object
         */
        $this->configs = $configs;
        $this->request = new Http\Request($configs->baseURI);

        /**
         * Subfolder
         * @var mixed
         */
        $this->subfolder = $subfolder;

        /**
         * Tratamento das variáveis
         */
        $controller = strtolower(str_replace('Controller', '', $controller));
        $action = ($controller == $configs->controllers->notFound ? 'indexAction' : $action);
        $action = str_replace('Action', '', $action);

        /**
         * Verifica se os valores padrão foram alterados no construtor do Controller.
         */
        $view_settings = new \stdClass;

        $default_values = [
            'partialsDir' => 'partials',
            'path' => $controller,
            'template' => true,
            'header' => 'header',
            'file' => $action,
            'footer' => 'footer',
            'title' => $this->configs->title
        ];

        foreach ($default_values as $setting => $value) {
            if (!$this->$setting) {
                $view_settings->$setting = $value;
                continue;
            }

            $view_settings->$setting = $this->$setting;
        }

        $this->setPartialsDir($view_settings->partialsDir)
                ->setPath($view_settings->path)
                ->setTemplate($view_settings->template)
                ->setHeader($view_settings->header)
                ->setFile($view_settings->file)
                ->setFooter($view_settings->footer)
                ->setTitle($view_settings->title);
    }

    /**
     * Define o diretório das views parciais
     * @param string  $partialsDir  Diretório
     */
    public function setPartialsDir(string $partialsDir, bool $overwrite = false): self
    {
        $viewsDir = $this->configs->views->directory;

        $partialsDir = $overwrite === false ? $this->subfolder . $partialsDir : $partialsDir;

        $this->partialsDir = $viewsDir . $partialsDir . DS;
        return $this;
    }

    /**
     * Define o título da página
     * @param string  $title  Título da página
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Define a pasta da view
     * @param string  $path  Caminho da View
     */
    public function setPath(string $path, bool $overwrite = false): self
    {
        $this->path = $overwrite === false ? $this->subfolder . $path : $path;
        return $this;
    }

    /**
     * Define se o arquivo é miolo (Inclusão de Cabeçalho e Rodapé) ou único
     * @param bool  $template  Template ON/OFF
     */
    public function setTemplate(bool $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Define o cabeçalho da view
     * @param string  $header  Cabeçalho da View
     */
    public function setHeader(string $header, bool $overwrite = false): self
    {
        $this->header = $overwrite === false ? $this->subfolder . $header : $header;
        return $this;
    }

    /**
     * Define o arquivo da view
     * @param string  $file  Arquivo da View
     */
    public function setFile(string $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Define o rodapé da view
     * @param string  $footer  Rodapé da View
     */
    public function setFooter(string $footer, bool $overwrite = false): self
    {
        $this->footer = $overwrite === false ? $this->subfolder . $footer : $footer;
        return $this;
    }

    /**
     * Define um conjunto de variáveis para a VIEW
     * @param array  $vars  Array com variáveis
     */
    public function setVars(array $vars): self
    {
        $this->vars = array_merge($this->vars, $vars);
        return $this;
    }

    /**
     * Define uma variável única para a VIEW
     * @param string  $name  Nome do índice
     * @param string  $value  Valor
     */
    public function setVar(string $name, $value): self
    {
        $this->vars[$name] = $value;
        return $this;
    }

    /**
     * Define os arquivos customizáveis que serão utilizados
     * @param string  $type  Tipo do arquivo
     * @param string|array  $assets  Arquivo Único | Array com os arquivos
     */
    public function setAssets(string $type, $assets): self
    {
        (is_array($assets)) ?
                        $this->assets[$type] = array_merge($this->assets[$type], $assets) :
                        array_push($this->assets[$type], $assets);

        return $this;
    }

    /**
     * Inclui os arquivos customizados
     * @param  string $type          Tipo de arquivo incluso, como: css ou js
     * @param  array  $custom_assets Links dos arquivos que serão incluídos
     * @return string                HTML formatado de acordo com o tipo de arquivo
     */
    private function assets(string $type, array $custom_assets = []): string
    {
        $add_assets = '';

        switch ($type) {
            case 'css':
                $tag = '<link type="text/css" rel="stylesheet" href="%s">' . "\n\r";
                break;

            case 'js':
                $tag = '<script type="text/javascript" src="%s"></script>' . "\n\r";
                break;
        }

        if (count($custom_assets))
            foreach ($custom_assets as $file)
                $add_assets .= sprintf($tag, $file);

        return $add_assets;
    }

    /**
     * Renderiza a VIEW
     * @param  string  $view  Nome do arquivo, sem extensão, a ser utilizado como VIEW
     */
    public function flush()
    {

        $default_data = [
            'title' => $this->title
        ];

        $data = array_merge($default_data, $this->vars);

        //Extract que transforma os parâmetros em variáveis disponíveis para a VIEW
        extract($data, EXTR_PREFIX_ALL, 'view');

        //Inclusão de ASSETS

        $add_css = $this->assets('css', $this->assets['css']);
        $add_js = $this->assets('js', $this->assets['js']);

        //Variáveis
        $baseURI = $this->configs->baseURI;
        $viewsDir = $this->configs->views->directory;
        $viewsExt = $this->configs->views->extension;

        //Atribuição das constantes
        define('BASE', $baseURI);
        define('ASSETS', $baseURI . 'public/assets/');
        define('BOWER', $baseURI . 'public/bower_components/');
        define('IMG', $baseURI . 'public/img/');
        define('CSS', $baseURI . 'public/css/');
        define('JS', $baseURI . 'public/js/');

        //Verifica a existência da VIEW
        $view = $viewsDir . $this->path . DS . $this->file . $viewsExt;

        if (!file_exists($view))
            throw new \Exception("Erro fatal: A view <'$view'> não foi encontrada. Por favor, crie a view e tente novamente.", 1);

        //Mecanismo de template
        if (!$this->template) {
            //Inclusão da view
            require_once($view);
            exit();
        }

        //Verifica a existência do Header e Footer customizado
        $header = $viewsDir . $this->header . $viewsExt;
        $footer = $viewsDir . $this->footer . $viewsExt;

        if (!file_exists($header) || !file_exists($footer))
            throw new \Exception("Erro fatal: O header <$header> ou o footer <$footer> não existe. Por favor, verifique e tente novamente.");

        //Inclusão dos arquivos
        require_once($header);
        require_once($view);
        require_once($footer);

        exit();
    }

    public function partial(string $view, array $params = [])
    {
        if (!empty($params))
            extract($params, EXTR_PREFIX_ALL, 'view');

        $viewsExt = $this->configs->views->extension;

        $viewFile = $this->partialsDir . '_' . $view . $viewsExt;

        if (!file_exists($viewFile))
            throw new \Exception("Erro fatal: A view <'$viewFile'> não foi encontrada. Por favor, crie a view e tente novamente.", 1);

        require($viewFile);
    }

    public function getRelativeURL(string $URL, bool $controller = true): string
    {
        $path = $controller === true ? $this->path . DS : $this->subfolder;

        return $this->configs->baseURI . $path . $URL;
    }

    public function printRelativeURL(string $URL, bool $controller = true)
    {
        $path = $controller === true ? $this->path . DS : $this->subfolder;

        echo $this->configs->baseURI . $path . $URL;
    }
}
