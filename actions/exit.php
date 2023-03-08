<?php

require_once('../utils/sessionManager/sessionManager.php');
function exitAccount(){

    $sessionManager = new SessionManager();
    $sessionManager->destroySession();
    header("Location: ../index.php");

}
exitAccount();
?>