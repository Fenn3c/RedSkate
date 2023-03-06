<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function addToCart()
{
    $sessionManager = new SessionManager();
    if (!isset($_POST['id_product'])) {
        var_dump($_POST);
        return;
    }
    $id_product = strip_tags($_POST['id_product']);

    if (!$sessionManager->idUser()) {
        $sessionManager->createTempUser();
    }

    $db = new DataBase();
    $cart_id = $db->isInCart($_SESSION['id_user'], $id_product);
    var_dump($cart_id);
    if ($cart_id) {
        $db->removeFromCart($cart_id);
    } else {
        $db->addToCart($_SESSION['id_user'], $id_product);
    }
}
addToCart();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

