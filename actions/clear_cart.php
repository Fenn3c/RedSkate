<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function clearCart()
{
    $sessionManager = new SessionManager();
    if (!$sessionManager->idUser()) {
        return;
    }

    $db = new DataBase();
    $db->clearCart($sessionManager->idUser());
    
}
clearCart();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
