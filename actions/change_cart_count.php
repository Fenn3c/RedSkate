<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function change_cart_count()
{
    $sessionManager = new SessionManager();
    if (!$sessionManager->idUser()) {
        return;
    }

    if (!isset($_POST['id_cart'])) {
        return;
    }
    $id_cart = strip_tags($_POST['id_cart']);

    $db = new Database();
    if (isset($_POST['dec'])) {
        $cart_product = $db->getCartProductByCartId($id_cart);
        if ((int)$cart_product['cart_count'] - 1  <= 0) {
            return;
        }
        $db->decCart($id_cart);
    } else if (isset($_POST['inc'])) {
        $cart_product = $db->getCartProductByCartId($id_cart);
        if ((int)$cart_product['cart_count'] + 1  > (int)$cart_product['product_count']) {
            return;
        }
        $db->incCart($id_cart);
    }

    $db = new DataBase();
}
change_cart_count();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
