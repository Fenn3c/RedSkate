<?php

require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function signUp()
{
    $sessionManager = new SessionManager();

    $required_fields_to_check = [
        'name', 'email', 'password', 'password_repeat', 'tos'
    ];

    $not_check_empty = ['tos'];

    foreach ($required_fields_to_check as $required_field_to_check) {
        if (!isset($_POST[$required_field_to_check])) {
            $sessionManager->setSessionField('REGISTRATION_ERROR', "Все поля должны быть заполнены");
            return;
        } else {
            if (trim(strip_tags($_POST[$required_field_to_check])) == '' && !in_array($required_field_to_check, $not_check_empty)) {
                $sessionManager->setSessionField('REGISTRATION_ERROR', 'Поля должны содержать текст');
                return;
            }
        }
    }
    $name = trim(strip_tags($_POST['name']));
    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));
    $repeatPassword = trim(strip_tags($_POST['password_repeat']));

    $db = new DataBase();
    if ($db->getUserByName($name)) {
        $sessionManager->setSessionField('REGISTRATION_ERROR', 'Пользователь с таким именем уже существет');
        return;
    }
    if ($db->getUserByEmail($email)) {
        $sessionManager->setSessionField('REGISTRATION_ERROR', 'Пользователь с такой почтой уже существет');
        return;
    }
    if ($password != $repeatPassword) {
        $sessionManager->setSessionField('REGISTRATION_ERROR', 'Пароли должны совпадать');
        return;
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (!(bool)$sessionManager->idUser()) {
        $db->createUser($name, $email, $passwordHash);
        header("Location: ../signin.php");
        return true;
    } else {
        $db->createUserFromTemp($sessionManager->idUser(), $name, $email, $passwordHash);
        $sessionManager->destroySession();
        header("Location: ../signin.php");
        return true;
    }
}
if (signUp()) {
    header("Location: ../signin.php");
} else {
    header("Location: ../signup.php");
}
