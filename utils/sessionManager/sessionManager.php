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



    public function createTempUser()
    {
        $db = new Database();
        $name = "Гость-" . mt_rand(1000, 9999);
        $_SESSION['id_user'] = $db->createTempUser($name);
    }
}
