<?php
namespace HXPHP\System\Services\Auth;

use HXPHP\System\{
    Http,
    Storage
};

class Auth
{
    /**
     * Injeção do Request
     * @var object
     */
    public $request;

    /**
     * Injeção do Response
     * @var object
     */
    public $response;

    /**
     * Injeção do controle de sessão
     * @var object
     */
    public $storage;
    private $url_redirect_after_login;
    private $url_redirect_after_logout;
    private $redirect;
    private $subfolder;

    /**
     * Método construtor
     */
    public function __construct(array $after_login, array $after_logout, bool $redirect = false, string $subfolder = 'default')
    {
        //Instância dos objetos injetados
        $this->request = new Http\Request;
        $this->response = new Http\Response;
        $this->storage = new Storage\Session\Session;

        if (!($after_login[$subfolder]) || !($after_logout[$subfolder]))
            throw new \Exception("Verifique as configuracoes de autenticacao para a subpasta: < $subfolder >", 1);

        //Configuração
        $this->url_redirect_after_login = $after_login[$subfolder];
        $this->url_redirect_after_logout = $after_logout[$subfolder];
        $this->redirect = $redirect;

        $this->subfolder = $subfolder;
    }

    /**
     * Autentica o usuário
     * @param  integer $user_id  ID do usuário
     * @param  string $username  Nome de usuário
     * @param string $user_role Role do usuário
     */
    public function login(int $user_id, string $username, string $user_role = null)
    {
        $user_id = intval(preg_replace("/[^0-9]+/", "", $user_id));
        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
        $login_string = hash('sha512', $username . $this->request->server('REMOTE_ADDR') . $this->request->server('HTTP_USER_AGENT'));

        $this->storage->set($this->subfolder . '_user_id', $user_id);
        $this->storage->set($this->subfolder . '_username', $username);
        $this->storage->set($this->subfolder . '_user_role', $user_role);
        $this->storage->set($this->subfolder . '_login_string', $login_string);

        if ($this->redirect)
            return $this->response->redirectTo($this->url_redirect_after_login);
    }

    /**
     * Método de logout de usuários
     */
    public function logout()
    {
        $this->storage->clear($this->subfolder . '_user_id');
        $this->storage->clear($this->subfolder . '_username');
        $this->storage->clear($this->subfolder . '_login_string');

        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        session_destroy();

        if ($this->redirect)
            return $this->response->redirectTo($this->url_redirect_after_logout);
    }

    /**
     * Valida a autenticação e redireciona mediante o estado do usuário
     * @param  boolean $redirect Parâmetro que define se é uma página pública ou não
     */
    public function redirectCheck(bool $redirect = false)
    {
        if ($redirect && $this->login_check())
            $this->response->redirectTo($this->url_redirect_after_login);
        elseif (!$this->login_check())
            if (!$redirect)
                $this->logout();
    }

    /**
     * Valida a autenticação e redireciona mediante o estado do usuário
     * @param array $roles Array com roles são permitidas o acesso a esta página
     */
    public function roleCheck(array $roles = [])
    {
        if ($this->login_check()) {
            if (!in_array($this->getUserRole(), $roles))
                $this->redirectCheck(true);
        } else
            $this->response->redirectTo($this->url_redirect_after_logout);
    }

    public function loginCheck()
    {
        return $this->login_check();
    }

    /**
     * Verifica se o usuário está logado
     * @return boolean Status da autenticação
     */
    public function login_check(): bool
    {
        if ($this->storage->exists($this->subfolder . '_user_id') &&
                $this->storage->exists($this->subfolder . '_username') &&
                $this->storage->exists($this->subfolder . '_login_string')) {

            $IP = is_null($this->request->server('HTTP_X_FORWARDED_FOR')) ? $this->request->server('REMOTE_ADDR') : $this->request->server('HTTP_X_FORWARDED_FOR');

            $login_string = hash('sha512', $this->storage->get($this->subfolder . '_username')
                                             . $IP
                                             . $this->request->server('HTTP_USER_AGENT'));

            if ($login_string == $this->storage->get($this->subfolder . '_login_string'))
                return true;
        }

        return false;
    }

    /**
     * Retorna a ID do usuário autenticado
     * @return integer ID do usuário
     */
    public function getUserId(): int
    {
        return $this->storage->get($this->subfolder . '_user_id');
    }

    /**
     * Retorna o role do usuário autenticado
     * @return string Role do usuário
     */
    public function getUserRole(): string
    {
        return $this->storage->get($this->subfolder . '_user_role');
    }
}