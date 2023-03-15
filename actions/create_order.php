<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');

function createOrder()
{
    $sessionManager = new SessionManager();
    if (!$sessionManager->idUser()) {
        return;
    }

    $required_fields_to_check = [
        'phone', 'email', 'delivery-method', 'pay-method', 'delivery-address'
    ];
    $not_check_empty = ['delivery-address'];

    foreach ($required_fields_to_check as $required_field_to_check) {
        if (!isset($_POST[$required_field_to_check])) {
            $sessionManager->setSessionField('CREATE_ORDER_ERROR', "Все поля должны быть заполнены");
            return;
        } else {
            if (trim(strip_tags($_POST[$required_field_to_check])) == '' && !in_array($required_field_to_check, $not_check_empty)) {
                $sessionManager->setSessionField('CREATE_ORDER_ERROR', 'Поля должны содержать текст');
                return;
            }
        }
    }
    $phone = trim(strip_tags($_POST['phone']));
    $email = trim(strip_tags($_POST['email']));
    $deliveryMethod = trim(strip_tags($_POST['delivery-method']));
    $payMethod = trim(strip_tags($_POST['pay-method']));
    $deliveryAddress = trim(strip_tags($_POST['delivery-address']));
    if ($deliveryMethod == 2) {
        if ($deliveryAddress == '') {
            $sessionManager->setSessionField('CREATE_ORDER_ERROR', 'Адрес доставки отсутсвует');
            return;
        }
    }
    $db = new Database();
    $id_order = $db->createOrder(
        $sessionManager->idUser(),
        1,
        $deliveryMethod,
        $payMethod,
        $phone,
        $email,
        $deliveryAddress
    );
    $db->decOrderProductsCountFromCart($sessionManager->idUser());
    $db->addOrderProductsFromCart($id_order, $sessionManager->idUser());
    $db->clearCart($sessionManager->idUser());
    return true;
}

if (createOrder()) {
    header("Location: ../profile.php");
} else {
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}
