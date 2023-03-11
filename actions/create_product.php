<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
require_once('../utils/middlewares/sessionMiddleware.php');
require_once('../utils/imageProcessing/imageProcessing.php');


const PREVIEW_FOLDER = '../data/product-preview';
const GALLERY_FOLDER = '../data/product-gallery';

function createProduct()
{
    $sessionManager = new SessionManager();
    $sessionMiddleware = new SessionMiddleware($sessionManager, '../index.php');
    $sessionMiddleware->onlyAdmin();

    // var_dump($_POST, $_FILES);
    $required_fields_to_check = [
        'name',
        'price',
        'old-price',
        'description',
        'count',
        'id_category',
        'color'
    ];
    $not_check_empty = ['old-price'];

    foreach ($required_fields_to_check as $required_field_to_check) {
        if (!isset($_POST[$required_field_to_check])) {
            $sessionManager->setSessionField('CREATE_PRODUCT_ERROR', "Все поля должны быть заполнены");
            var_dump('Не заполнено', $required_field_to_check);
            return;
        } else {
            if (trim(strip_tags($_POST[$required_field_to_check])) == '' && !in_array($required_field_to_check, $not_check_empty)) {
                $sessionManager->setSessionField('CREATE_PRODUCT_ERROR', 'Поля должны содержать текст');
                var_dump('Пусто', $required_field_to_check);
                return;
            }
        }
    }
    if (!isset($_FILES['preview'])) {
        $sessionManager->setSessionField('CREATE_PRODUCT_ERROR', "Не удалось загрузить превью-изображение");
        return;
    }
    if (!isset($_FILES['images'])) {
        $sessionManager->setSessionField('CREATE_PRODUCT_ERROR', "Не удалось загрузить изображения");
        return;
    }
    $name = trim(strip_tags($_POST['name']));
    $price = trim(strip_tags($_POST['price']));
    $oldPrice = trim(strip_tags($_POST['old-price']))  == '' ? null : trim(strip_tags($_POST['old-price']));
    $description = trim(strip_tags($_POST['description']));
    $count = trim(strip_tags($_POST['count']));
    $id_category = trim(strip_tags($_POST['id_category']));
    $color = trim(strip_tags($_POST['color']));
    $preview = $_FILES['preview'];
    $images = $_FILES['images'];
    $new = isset($_POST['new']) ? 1 : 0;
    $bestSeller = isset($_POST['bestseller']) ? 1 : 0;

    $preview_path = '';
    $images_pathes = [];

    $check_preview = can_upload($_FILES['preview']);

    if ($check_preview === true) {
        $preview_path = upload_image($_FILES['preview'], PREVIEW_FOLDER);
    } else {
        $sessionManager->setSessionField('CREATE_PRODUCT_ERROR', $check_preview);
        return;
    }
    $newImages = [];
    for ($i = 0; $i < count($images['name']); $i++) {
        $newImage = [];
        foreach ($images as $imgName => $image) {
            $newImage[$imgName] = $image[$i];
        }
        array_push($newImages, $newImage);
    }

    foreach ($newImages as $newImage) {
        $check_image = can_upload($newImage);
        if ($check_image === true) {
            array_push($images_pathes, upload_image($newImage, GALLERY_FOLDER));
        } else {
            $sessionManager->setSessionField('CREATE_PRODUCT_ERROR', $check_image);
            var_dump($check_image);
            return;
        }
    }

    $db = new DataBase();
    $id_product = $db->createProduct(
        $name,
        $price,
        $oldPrice,
        $description,
        $preview_path,
        $color,
        $id_category,
        $count,
        $new,
        $bestSeller
    );
    foreach ($images_pathes as $image_path) {
        $db->createProductImage($id_product, $image_path);
    }
}

createProduct();
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

