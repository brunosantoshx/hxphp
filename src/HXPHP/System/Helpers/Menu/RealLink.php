<?php
namespace HXPHP\System\Helpers\Menu;

class RealLink
{
    private $siteURL;
    private $baseURI;

    public function __construct(string $siteURL, string $baseURI)
    {
        $this->siteURL = $siteURL;
        $this->baseURI = $baseURI;
    }

    /**
     * Retorna o link com os coringas preenchidos
     * @param  string $value Link
     * @return string        Link tratado
     */
    public function get($value)
    {
        $value = str_replace(
                ['% %', '%/'], ['%%', '%'], $value
        );

        return str_replace(
                [
            '%siteURL%',
            '%site_URL',
            '%site_url',
            '%baseURI%',
            '%base_uri%'
                ], [
            $this->siteURL . $this->baseURI,
            $this->siteURL . $this->baseURI,
            $this->siteURL . $this->baseURI,
            $this->baseURI,
            $this->baseURI
                ], $value
        );
    }
}