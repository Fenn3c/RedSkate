<?php

class SessionMiddleware
{
    private $db;
    private $sessionManager;
    private $redirectUrl;
    public function __construct($sessionManager, $redirectUrl)
    {
        $this->sessionManager = $sessionManager;
        if (!$sessionManager) {
            $this->redirect();
        }
        $this->db = new DataBase();
        $this->redirectUrl = $redirectUrl;
    }

    public function onlyAuthorized()
    {
        if (!$this->sessionManager->idUser()) {
            $this->redirect();
        }
    }
    public function onlyAdmin()
    {
        if ($this->sessionManager->idUser()) {
            if (!$this->isAdmin()) {
                $this->redirect();
            }
        } else {
            $this->redirect();
        }
    }

    public function isAdmin()
    {
        $isAdmin = $this->db->getUserData($this->sessionManager->idUser())['permissions'] >= 2;
        return $isAdmin;
    }
    private function redirect()
    {
        echo 'redirecting';
        header("Location: " . $this->redirectUrl);
    }
}
