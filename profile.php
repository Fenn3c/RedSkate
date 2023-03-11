<?php
require_once('./utils/database/database.php');
require_once('./utils/formaters/format_price.php');
require_once('./utils/formaters/get_discount.php');
require_once('./utils/sessionManager/sessionManager.php');
$db = new Database();
$sessionManager = new SessionManager();
$id_user = $sessionManager->idUser();
$orderProducts = [];
$user = [];
if ($id_user) {
    $orderProducts = $db->getUserOrderProducts($id_user);
    $user = $db->getUserData($id_user);
}
var_dump($orderProducts);
var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль - RedSkate</title>
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>

    <?php include_once('./header.php'); ?>

    <main class="main main_main-page">
        <div class="main__wrap">
            <section class="profile">
                <h2 class="profile__title title">Профиль</h2>
                <p class="error"><?= $sessionManager->getSessionField('UPDATE_PROFILE_ERROR'); ?></p>
                <? $sessionManager->clearSessionField('UPDATE_PROFILE_ERROR'); ?>
                <?php
                if ($id_user && $user['password']) :
                ?>
                    <div class="profile__card">
                        <div class="profile__pfp-wrap">
                            <?
                            $pfp = $user['pfp'] ? "./data/pfps/" . $user['pfp'] : "./assets/img/png/user-default.png";
                            ?>
                            <img class="profile__pfp" src="<?= $pfp ?>" alt="userpfp">
                            <form class="profile__pfp-form" enctype="multipart/form-data" method="post" id="pfp-form" action="./actions/update_pfp.php">
                                <input class="profile__pfp-btn" type="file" name="pfp">
                                <button type="submit" hidden></button>
                            </form>
                        </div>
                        <form class="profile__card-inputs" id="edit-profile-form" method="post" action="./actions/update_profile.php">
                            <div class="input">
                                <label class="input__label" for="name"></label>
                                <input type="text" class="input__input" name="name" id="name" placeholder="Имя пользователя" value="<?= $user['name'] ?>" required>
                            </div>
                            <div class="input">
                                <label class="input__label" for="email"></label>
                                <input type="email" class="input__input" name="email" id="email" placeholder="Почта" value="<?= $user['email'] ?>" required>
                            </div>

                            <div class="input">
                                <label class="input__label" for="phone"></label>
                                <input type="tel" class="input__input" name="phone" id="phone" placeholder="Номер телефона" value="<?= $user['phone'] ?>">
                            </div>

                            <div class="input">
                                <label class="input__label" for="address"></label>
                                <input type="text" class="input__input" name="address" id="address" value="<?= $user['address'] ?>" placeholder="Адрес">
                            </div>

                            <button class="button" id="edit-profile-btn" type="submit">Обновить</button>
                        </form>
                    </div>

                <? else : ?>
                    <p>
                        <a href="./signup.php" class="link">
                            Создайте
                        </a>
                        или
                        <a href="./signin.php" class="link">
                            войдите
                        </a> в
                        аккаунт чтобы просмотреть профиль
                    </p>
                <? endif; ?>
            </section>

            <section class="products">
                <h2 class="products__title title">Мои заказы</h2>
                <div class="products__list">

                    <? foreach ($orderProducts as $product) : ?>
                        <div class="products__list-item product-card">
                            <div class="product-card__bg" style="background-color: <?= $product['color'] ?>">
                                <a href="./product.php?id_product=<?= $product['id_product'] ?>" class="product-card__link">
                                    <img src="./data/product-preview/<?= $product['preview'] ?>" alt="" class="product-card__img">
                                </a>
                            </div>

                            <a href="#" class="product-card__link">
                                <p class="product-card__title"><?= $product['name'] ?></p>
                            </a>
                            <div class="product-card__order-info">
                                <?php
                                switch ($product['id_order_status']):
                                    case 1:
                                ?>
                                        <span class="product-card__order-yellow">
                                            Создан
                                        </span>

                                    <?
                                        break;
                                    case 2:
                                    ?>
                                        <span class="product-card__order-green">
                                            Подтвержден
                                        </span>
                                    <?
                                        break;
                                    case 3:
                                    ?>
                                        <span class="product-card__order-green">
                                            Готов к выдаче
                                        </span>
                                    <?
                                        break;
                                    case 4:
                                    ?>
                                        <span class="product-card__order-yellow">
                                            Ожидание доставки
                                        </span>
                                    <?
                                        break;
                                    case 5:
                                    ?>
                                        <span class="product-card__order-green">Выполнен</span>
                                        <a href="./product.php?id_product=<?= $product['id_product'] ?>" class="link link_underline">Оставить отзыв</a>
                                <?
                                        break;
                                endswitch;
                                ?>
                            </div>
                            <div class="product-card__bottom">
                                <span class="product-card__price"><?= format_price($product['final_price']) ?></span>

                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </section>
            <form action="./actions/exit.php">
                <?
                if ($sessionManager->idUser()) :
                ?>
                    <button class="button">Выйти из аккаунта</button>
                <? endif; ?>
            </form>
        </div>
    </main>


    <?php include_once('./footer.php'); ?>
    <script src="./assets/scripts/form-check.js">
    </script>
    <script>
        formCheck(document.getElementById('edit-profile-form'), document.getElementById('edit-profile-btn'));
    </script>
    <script>
        const form = document.getElementById('pfp-form')
        form.addEventListener('change', function() {
            form.submit();
        });
    </script>
</body>

</html>