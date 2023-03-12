<?php
require_once('./utils/database/database.php');
require_once('./utils/formaters/format_price.php');
require_once('./utils/formaters/get_discount.php');
require_once('./utils/sessionManager/sessionManager.php');
require_once('./utils/middlewares/sessionMiddleware.php');
$db = new Database();
$sessionManager = new SessionManager();
$sessionMiddleware = new SessionMiddleware($sessionManager, './index.php');
$sessionMiddleware->onlyAdmin();


$products = $db->getProducts();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - RedSkate</title>
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>
    <?php include_once('./header.php'); ?>
    <main class="main main_main-page">
        <div class="main__wrap">
            <section class="products">
                <h2 class="products__title">
                    Товары
                </h2>

                <div class="product__breadcrumb">
                    <a href="./admin.php" class="link">Панель администратора</a>
                </div>

                <div class="">
                    <a href="./create_product.php" class="button">Создать товар</a><br>
                </div>

                <table class="table">
                    <tr class="table__row">
                        <th class="table__header">
                            Превью
                        </th>
                        <th class="table__header">
                            Название
                        </th>
                        <th class="table__header">
                            Категория
                        </th>
                        <th class="table__header">
                            Цена
                        </th>

                        <th class="table__header">
                            Цена без акции
                        </th>
                        <th class="table__header">Действия</th>
                    </tr>
                    <? foreach ($products as $product) : ?>
                        <tr class="table__row">
                            <td class="table__item">
                                <img width="100" height="100" src="./data/product-preview/<?= $product['preview'] ?>" alt="">

                            </td>
                            <td class="table__item">
                                <?= $product['name'] ?>
                            </td>
                            <td class="table__item">
                                <?= $product['category_name'] ?>
                            </td>
                            <td class="table__item">
                                <?= format_price($product['price']) ?>
                            </td>
                            <td class="table__item">
                                <?= $product['old_price'] ? format_price($product['old_price']) : 'Не указ.' ?>
                            </td>
                            <td class="table__item">
                                <div class="table__links">
                                    <a class="button" href="./edit_product.php?id_product=<?= $product['id_product'] ?>">
                                        Изменить
                                    </a>
                                    <a class="button" href="./actions/delete_product.php?id_product=<?= $product['id_product'] ?>">
                                        Удалить
                                    </a>
                                </div>

                            </td>
                        </tr>
                    <? endforeach; ?>
                </table>

        </div>
        </section>
    </main>

    <?php include_once('./footer.php'); ?>
</body>

</html>