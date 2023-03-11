<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
require_once('../utils/middlewares/sessionMiddleware.php');
require_once('../utils/imageProcessing/imageProcessing.php');

const PREVIEW_FOLDER = '../data/product-preview';
const GALLERY_FOLDER = '../data/product-gallery';
function deleteProduct()
{
    $sessionManager = new SessionManager();
    $sessionMiddleware = new SessionMiddleware($sessionManager, '../index.php');
    $sessionMiddleware->onlyAdmin();
    if (!$sessionMiddleware->isAdmin()) {
        return;
    }
    if (!isset($_GET['id_product'])) {
        var_dump($_GET);
        return;
    }
    $id_product = $_GET['id_product'];
    $db = new Database();

    $preview = $db->getProductById($id_product)['preview'];

    delete_image($preview, PREVIEW_FOLDER);
    $productImages = $db->getProductImages($id_product);

    foreach ($productImages as $productImage) {
        delete_image($productImage['image'], GALLERY_FOLDER);
    }

    $db->deleteProduct($id_product);
}
deleteProduct();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
