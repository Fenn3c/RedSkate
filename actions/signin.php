<?php

require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function signIn()
{
    $sessionManager = new SessionManager();

    $required_fields_to_check = [
        'email', 'password'
    ];

    $not_check_empty = [];

    foreach ($required_fields_to_check as $required_field_to_check) {
        if (!isset($_POST[$required_field_to_check])) {
            $sessionManager->setSessionField('SIGNIN_ERROR', "Все поля должны быть заполнены");
            return;
        } else {
            if (trim(strip_tags($_POST[$required_field_to_check])) == '' && !in_array($required_field_to_check, $not_check_empty)) {
                $sessionManager->setSessionField('SIGNIN_ERROR', 'Поля должны содержать текст');
                return;
            }
        }
    }
    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));

    $db = new DataBase();

    $user = $db->getUserByEmail($email);
    if (!$user) {
        $sessionManager->setSessionField('SIGNIN_ERROR', 'Неверное имя пользователя или пароль');
        header("Location: ../signin.php");
        return;
    }
    if (!password_verify($password, $user['password'])) {
        $sessionManager->setSessionField('SIGNIN_ERROR', 'Неверное имя пользователя или пароль');
        header("Location: ../signin.php");
        return;
    }
    $sessionManager->setUserId($user['id_user']);
    header('Location: ../index.php');
    return;
}
signIn();
