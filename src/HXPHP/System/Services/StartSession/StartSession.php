<?php
namespace HXPHP\System\Services\StartSession;

class StartSession
{
    /**
     * Security Session Start
     * @param  boolean $regenerate Regerar sessão após start
     * @return void
     */
    static function sec_session_start($regenerate = false)
    {
        ini_set('session.use_only_cookies', 1);

        $cookieParams = session_get_cookie_params();

        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], false, true);

        session_name('sec_session_id');
        session_start();

        if ($regenerate)
            session_regenerate_id(true);
    }
}