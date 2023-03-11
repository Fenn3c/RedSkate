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
                    Панель администратора
                </h2>
                <a href="./admin_orders.php" class="button">
                    Заказы
                </a> <br>
                <a href="./admin_products.php" class="button">
                    Товары
                </a>


        </div>
        </section>
    </main>

    <?php include_once('./footer.php'); ?>
</body>

</html>