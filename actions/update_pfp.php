<?php

require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
require_once('../utils/imageProcessing/imageProcessing.php');

const PFP_FOLDER = '../data/pfps';
function updatePfp()
{
    $sessionManager = new SessionManager();
    if (!$sessionManager->idUser()) {
        return;
    }
    if (isset($_FILES['pfp'])) {
        $check_pfp = can_upload($_FILES['pfp']);
        if ($check_pfp === true) {
            $upload = upload_image($_FILES['pfp'], PFP_FOLDER);
            $db = new Database();
            $user = $db->getUserData($sessionManager->idUser());
            if ($user['pfp']) {
                delete_image($user['pfp'], PFP_FOLDER);
            }
            $db->updateUserPfp($sessionManager->idUser(), $upload);
        } else {
            $sessionManager->setSessionField('PFP_ERROR', $check_pfp);
            return;
        }
    } else{
        var_dump($_FILES, $_POST);
        return;
    }

    // $db->updateUserInfo($sessionManager->idUser(), $name, $email, $phone, $address);


    return true;
}

updatePfp();
header("Location: ../profile.php");
