<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function addToFavourites()
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
    $favourite_id = $db->isInFavourites($_SESSION['id_user'], $id_product);
    var_dump($favourite_id);
    if ($favourite_id) {
        $db->removeFromFavourites($favourite_id);
    } else {
        $db->addToFavourites($_SESSION['id_user'], $id_product);
    }
}
addToFavourites();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
