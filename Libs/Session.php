<?php
class Session
{
    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function getSession($key)
    {
        if (isset($_SESSION[$key])) {
            return  $_SESSION[$key];
        }
    }

    public static function deleteSession($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_destroy();
    }
}
