<?php
namespace HXPHP\System\Modules\Messages;

class Messages
{
    /**
     * Contém o conteúdo do template JSON
     * @var array
     */
    private $content;

    /**
     * Caminho do arquivo
     * @var string
     */
    private $file;

    /**
     * Bloco padrão
     * @var string
     */
    private $block = null;

    /**
     * Método construtor
     * @param string $template Nome do arquivo que encontra-se na sub-pasta 'templates'
     */
    public function __construct(string $file)
    {
        /**
         * Recebe o conteúdo JSON do template definido
         * @var LoadTemplate
         */
        $template = new LoadTemplate($file);
        $this->file = $template->getTemplatePath();

        /**
         * JSON => ARRAY
         * @var array
         */
        if ($template->getJson())
            $this->content = json_decode($template->getJson(), true);
    }

    /**
     * Altera o bloco padrão
     * @param string $block
     */
    public function setBlock(string $block): self
    {
        $this->block = $block;
        return $this;
    }

    /**
     * Cria um atalho para acessar o método getByCode
     * desde que o bloco padrão seja configurado
     * @param  string $method getByCode()
     * @param  array  $args   Argumentos passados para o método
     */
    public function __call(string $method, array $args)
    {
        $block = $this->block;

        if ($block)
            return call_user_func_array([&$this->$block, $method], $args);

        throw new \Exception("O metodo <$method> nao existe.", 1);
    }

    /**
     * Retorna uma instância do objeto Template configurada mediante o bloco informado
     * @param  string $block Nome do bloco
     * @return object        Instância do objeto Template
     */
    public function __get(string $block)
    {
        if ($this->content[$block]) {
            $this->$block = new Template($this->content[$block]);

            return $this->$block;
        }

        throw new \Exception("O bloco <'$block'> nao foi encontrado no template <'$this->file'>.", 1);
    }
}