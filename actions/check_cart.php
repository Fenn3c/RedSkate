<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function checkCart()
{
    $sessionManager = new SessionManager();
    if (!$sessionManager->idUser()) {
        return;
    }

    $db = new DataBase();
    if (!$db->checkCartCorrect($sessionManager->idUser())) {
        $db->clearCart($sessionManager->idUser());
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            header("Location: ../index.php");
        }
        return;
    }
    header("Location: ../order.php");

}
checkCart();
