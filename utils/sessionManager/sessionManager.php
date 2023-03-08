<?php

class SessionManager
{
    public function __construct()
    {
        session_start();
    }

    public function idUser()
    {
        if (isset($_SESSION['id_user'])) {
            return $_SESSION['id_user'];
        } else return false;
    }
    public function setUserId($id_user){
        $_SESSION['id_user'] = $id_user;
    }



    public function createTempUser()
    {
        $db = new Database();
        $name = "Гость-" . mt_rand(1000, 9999);
        $_SESSION['id_user'] = $db->createTempUser($name);
    }
    public function setSessionField($field, $arg)
    {
        $_SESSION[$field] = $arg;
    }
    public function clearSessionField($field)
    {
        unset($_SESSION[$field]);
    }

    public function getSessionField($field)
    {
        if (isset($_SESSION[$field])) {
            return $_SESSION[$field];
        } else {
            return null;
        }
    }
    public function destroySession()
    {
        $_SESSION = [];
        session_destroy();
    }
}
