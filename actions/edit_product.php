<?php
require_once('../utils/database/database.php');
require_once('../utils/sessionManager/sessionManager.php');
require_once('../utils/middlewares/sessionMiddleware.php');
require_once('../utils/imageProcessing/imageProcessing.php');


const PREVIEW_FOLDER = '../data/product-preview';
const GALLERY_FOLDER = '../data/product-gallery';

function editProduct()
{
    $sessionManager = new SessionManager();
    $sessionMiddleware = new SessionMiddleware($sessionManager, '../index.php');
    $sessionMiddleware->onlyAdmin();
    $db = new DataBase();


    // var_dump($_POST, $_FILES);
    $required_fields_to_check = [
        'id_product',
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
            $sessionManager->setSessionField('EDIT_PRODUCT_ERROR', "Все поля должны быть заполнены");
            var_dump('Не заполнено', $required_field_to_check);
            return;
        } else {
            if (trim(strip_tags($_POST[$required_field_to_check])) == '' && !in_array($required_field_to_check, $not_check_empty)) {
                $sessionManager->setSessionField('EDIT_PRODUCT_ERROR', 'Поля должны содержать текст');
                var_dump('Пусто', $required_field_to_check);
                return;
            }
        }
    }
    $id_product = (int)$_POST['id_product'];
    $product = $db->getProductById($id_product);

    $name = trim(strip_tags($_POST['name']));
    $price = trim(strip_tags($_POST['price']));
    $oldPrice = trim(strip_tags($_POST['old-price']))  == '' ? null : trim(strip_tags($_POST['old-price']));
    $description = trim(strip_tags($_POST['description']));
    $count = trim(strip_tags($_POST['count']));
    $id_category = trim(strip_tags($_POST['id_category']));
    $color = trim(strip_tags($_POST['color']));
    $new = isset($_POST['new']) ? 1 : 0;
    $bestSeller = isset($_POST['bestseller']) ? 1 : 0;


    $db = new DataBase();
    $db->editProduct(
        $id_product,
        $name,
        $price,
        $oldPrice,
        $description,
        $color,
        $id_category,
        $count,
        $new,
        $bestSeller
    );

    if (isset($_FILES['preview'])) {
        if ($_FILES['preview']['error'] == 0) {
            $check_preview = can_upload($_FILES['preview']);
            if ($check_preview === true) {
                $preview_path = upload_image($_FILES['preview'], PREVIEW_FOLDER);
                $db->editProductPreview($id_product, $preview_path);
                delete_image($product['preview'], PREVIEW_FOLDER);
            } else {
                $sessionManager->setSessionField('EDIT_PRODUCT_ERROR', $check_preview);
                return;
            }
        }
    }

    if (isset($_FILES['images'])) {
        if ($_FILES['images']['error'][0] == 0) {
            $images_pathes = [];
            $images = $_FILES['images'];
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
                    $sessionManager->setSessionField('EDIT_PRODUCT_ERROR', $check_image);
                    var_dump($check_image);
                    return;
                }
            }

            var_dump($images_pathes);

            $oldImages = $db->getProductImages($id_product);
            foreach ($oldImages as $oldImage) {
                delete_image($oldImage['image'], GALLERY_FOLDER);
                $db->deleteProductImage($oldImage['id_product_image']);
            }

            foreach ($images_pathes as $image_path) {
                $db->createProductImage($id_product, $image_path);
            }
        }
    }
}

editProduct();
header("Location: ../admin_products.php");
