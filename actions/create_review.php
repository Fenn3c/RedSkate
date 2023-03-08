<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
function createReview()
{
    $sessionManager = new SessionManager();
    if (!isset($_POST['id_product']) || !isset($_POST['review']) || !isset($_POST['rating'])) {
        var_dump($_POST);
        return;
    }
    $id_product = strip_tags($_POST['id_product']);
    $text = trim(strip_tags($_POST['review']));
    $rating= strip_tags($_POST['rating']);
    if ($text == '') {
        return;
    }
    if (!$sessionManager->idUser()) {
        return;
    }
    $db = new DataBase();
    $db->createReview(
        $sessionManager->idUser(),
        $id_product,
        $text,
        $rating
    );
}
createReview();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
