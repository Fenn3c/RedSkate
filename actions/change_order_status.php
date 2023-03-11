<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
require_once('../utils/middlewares/sessionMiddleware.php');
function changeOrderStatus()
{
    $sessionManager = new SessionManager();
    $sessionMiddleware = new SessionMiddleware($sessionManager, '../index.php');
    $sessionMiddleware->onlyAdmin();
    if (!$sessionMiddleware->isAdmin()) {
        return;
    }
    if (!isset($_POST['id_order']) || !isset($_POST['id_order_status'])) {
        var_dump($_POST);
        return;
    }
    $id_order = $_POST['id_order'];
    $id_order_status = $_POST['id_order_status'];
    $db = new Database();
    $db->updateOrderStatus($id_order, $id_order_status);
}
changeOrderStatus();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
