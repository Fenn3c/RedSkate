<?php

require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');

function updateProfile()
{
    $sessionManager = new SessionManager();
    var_dump($_POST);
    if (!$sessionManager->idUser()) {
        return;
    }

    $required_fields_to_check = [
        'name', 'email', 'address', 'phone'
    ];

    $not_check_empty = ['address', 'phone'];

    foreach ($required_fields_to_check as $required_field_to_check) {
        if (!isset($_POST[$required_field_to_check])) {
            $sessionManager->setSessionField('UPDATE_PROFILE_ERROR', "Все поля должны быть заполнены $required_field_to_check");
            return;
        } else {
            if (trim(strip_tags($_POST[$required_field_to_check])) == '' && !in_array($required_field_to_check, $not_check_empty)) {
                $sessionManager->setSessionField('UPDATE_PROFILE_ERROR', 'Поля должны содержать текст');
                return;
            }
        }
    }
    $name = trim(strip_tags($_POST['name']));
    $email = trim(strip_tags($_POST['email']));
    $phone = trim(strip_tags($_POST['phone']));
    $address = trim(strip_tags($_POST['address']));

    $db = new DataBase();
    $nameUser = $db->getUserByName($name);
    $emailUser = $db->getUserByEmail($email);

    if ($nameUser) {
        if ($nameUser['id_user'] != $sessionManager->idUser()) {
            $sessionManager->setSessionField('UPDATE_PROFILE_ERROR', 'Пользователь с таким именем уже существет');
            return;
        }
    }
    if ($emailUser) {
        if ($emailUser['id_user'] != $sessionManager->idUser()) {
            $sessionManager->setSessionField('UPDATE_PROFILE_ERROR', 'Пользователь с такой почтой уже существет');
            return;
        }
    }

    $db->updateUserInfo($sessionManager->idUser(), $name, $email, $phone, $address);


    header("Location: ../profile.php");
    return true;
}

updateProfile();
