<?php
require_once('./utils/database/database.php');
require_once('./utils/formaters/format_price.php');
require_once('./utils/formaters/get_discount.php');
require_once('./utils/sessionManager/sessionManager.php');
$db = new Database();
$sessionManager = new SessionManager();
$id_user = $sessionManager->idUser();
$cartProducts = [];
if ($id_user) {
    $cartProducts = $db->getCartProducts($id_user);
}
var_dump($cartProducts);
$newProducts = $db->getNewProducts();
$categories = $db->getCategories();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - RedSkate</title>
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>

    <?php include_once('./header.php'); ?>
    <main class="main main_main-page">
        <div class="main__wrap">
            <section class="cart">
                <div class="cart__title-wrap">
                    <h2 class="cart__title title">Корзина</h2>
                    <p class="cart__count"><?= count($cartProducts) ?> тв.</p>
                </div>
                <form action="./actions/clear_cart.php" method="post">
                    <button class="link link_btn" type="submit">Очисть корзину</button>
                </form>
                <div class="cart__main">
                    <div class="cart__products">
                        <!-- <label class="checkbox__label">
                            <input type="checkbox" class="checkbox" id="check-all" checked>
                            <span class="checkbox__label">Выбрать все</span>
                        </label> -->
                        <? foreach ($cartProducts as $product) : ?>

                            <div class="products__list-item product-card product-card_cart">
                                <div class="product-card__bg-wrap_cart">
                                    <div class="product-card__bg" style="background-color: <?= $product['color'] ?>">
                                        <a href="#" class="product-card__link">
                                            <img src="./data/product-preview/<?= $product['preview'] ?>" alt="" class="product-card__img">
                                        </a>
                                    </div>
                                </div>

                                <div class="product-cart__info-wrap_cart">
                                    <div class="product-card__top-wrap_cart">
                                        <a href="#" class="product-card__link">
                                            <p class="product-card__title"><?= $product['name'] ?></p>
                                        </a>
                                        <!-- <label class="checkbox__label">
                                            <input type="checkbox" class="checkbox cart__checkbox" checked>
                                            <span class="checkbox__label"></span>
                                        </label> -->
                                    </div>

                                    <div class="product-card__bottom-wrap_cart">
                                        <div>
                                            <p class="product-card__availability-text_cart">В наличии: <?= $product['product_count'] ?>шт.</p>

                                            <form action="./actions/change_cart_count.php" method="post">
                                                <input type="hidden" name="id_cart" value="<?= $product['id_cart'] ?>">
                                                <div class="product-card__input-count input-count">
                                                    <button type="submit" class="input-count__btn input-count__dec" name="dec">-</button>
                                                    <input class="input-count__input" type="number" value="<?=$product['cart_count']?>" min="1" max="<?= $product['product_count'] ?>" disabled>
                                                    <button type="submit" class="input-count__btn input-count__inc" name="inc">+</button>
                                                </div>
                                            </form>

                                            <form action="./actions/add_to_cart.php" method="post">
                                                <input type="hidden" name="id_product" value="<?= $product['id_product'] ?>">
                                                <button class="link link_btn">Убрать</button>
                                            </form>

                                        </div>
                                        <div class="product-card__bottom">
                                            <span class="product-card__price"><?= format_price($product['price']) ?></span>
                                            <? if ($product['old_price']) : ?>
                                                <span class="product-card__price_crossed"><?= format_price($product['old_price']) ?></span>
                                            <? endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>


                    </div>
                    <div class="cart__order-wrap">

                        <div class="cart__order">
                            <p class="cart__order-title">Условия заказа</p>
                            <p class="cart__order-summary-text">Итого:</p>
                            <div class="cart__order-summary">
                                <?php
                                $cardSum = 0;
                                $cardCount = 0;
                                foreach ($cartProducts as $cp) {
                                    $cardSum += $cp['price'] * $cp['cart_count'];
                                    $cardCount += $cp['cart_count'];
                                }
                                ?>
                                <p class="cart__order-count"><?= $cardCount ?> шт.</p>
                                <p class="cart__order-price"><?= format_price($cardSum) ?></p>
                            </div>
                            <button class="button">Перейти к оформлению</button>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

    <?php include_once('./footer.php'); ?>

    <!-- <script src="./assets/styles/blocks/input-count/input-count.js"> -->
    <!-- </script> -->
    <script>
        const checkAll = document.getElementById('check-all')
        const checkboxes = document.querySelectorAll('.cart__checkbox')

        checkAll.addEventListener('click', () => {
            if (checkAll.checked) {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true
                })
            } else {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false
                })
            }
        })

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', () => {
                let allChecked = true
                checkboxes.forEach(checkCheckbox => {
                    if (checkCheckbox.checked == false) {
                        allChecked = false
                    }
                })
                if (allChecked) {
                    checkAll.checked = true
                } else {
                    checkAll.checked = false
                }
            })
        })
    </script>
</body>

</html>