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
                    <p class="cart__count">2 шт.</p>
                </div>
                <div class="cart__main">
                    <div class="cart__products">
                        <label class="checkbox__label">
                            <input type="checkbox" class="checkbox" id="check-all" checked>
                            <span class="checkbox__label">Выбрать все</span>
                        </label>

                        <div class="products__list-item product-card product-card_cart">
                            <div class="product-card__bg-wrap_cart">
                                <div class="product-card__bg">
                                    <a href="#" class="product-card__link">
                                        <img src="./assets/img/png/product-img.png" alt="" class="product-card__img">
                                    </a>
                                </div>
                            </div>

                            <div class="product-cart__info-wrap_cart">
                                <div class="product-card__top-wrap_cart">
                                    <a href="#" class="product-card__link">
                                        <p class="product-card__title">Скейтборд в сборе Footwork Waves 8”</p>
                                    </a>
                                    <label class="checkbox__label">
                                        <input type="checkbox" class="checkbox cart__checkbox" checked>
                                        <span class="checkbox__label"></span>
                                    </label>
                                </div>

                                <div class="product-card__bottom-wrap_cart">
                                    <div>
                                        <p class="product-card__availability-text_cart">В наличии: 4шт.</p>

                                        <div class="input-count">
                                            <button class="input-count__btn input-count__dec">-</button>
                                            <input class="input-count__input" type="number" value="1" min="1" max="4">
                                            <button class="input-count__btn input-count__inc">+</button>
                                        </div>

                                    </div>
                                    <div class="product-card__bottom">
                                        <span class="product-card__price">5 243 ₽</span>
                                        <span class="product-card__price_crossed">5 243 ₽</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="products__list-item product-card product-card_cart">
                            <div class="product-card__bg-wrap_cart">
                                <div class="product-card__bg">
                                    <a href="#" class="product-card__link">
                                        <img src="./assets/img/png/product-img.png" alt="" class="product-card__img">
                                    </a>
                                </div>
                            </div>

                            <div class="product-cart__info-wrap_cart">
                                <div class="product-card__top-wrap_cart">
                                    <a href="#" class="product-card__link">
                                        <p class="product-card__title">Скейтборд в сборе Footwork Waves 8”</p>
                                    </a>
                                    <label class="checkbox__label">
                                        <input type="checkbox" class="checkbox cart__checkbox" checked>
                                        <span class="checkbox__label"></span>
                                    </label>
                                </div>

                                <div class="product-card__bottom-wrap_cart">
                                    <div>
                                        <p class="product-card__availability-text_cart">В наличии: 4шт.</p>

                                        <div class="input-count">
                                            <button class="input-count__btn input-count__dec">-</button>
                                            <input class="input-count__input" type="number" value="1" min="1" max="4">
                                            <button class="input-count__btn input-count__inc">+</button>
                                        </div>

                                    </div>
                                    <div class="product-card__bottom">
                                        <span class="product-card__price">5 243 ₽</span>
                                        <span class="product-card__price_crossed">5 243 ₽</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="cart__order-wrap">

                        <div class="cart__order">
                            <p class="cart__order-title">Условия заказа</p>
                            <p class="cart__order-summary-text">Итого:</p>
                            <div class="cart__order-summary">
                                <p class="cart__order-count">2 шт.</p>
                                <p class="cart__order-price">15 600 ₽</p>
                            </div>
                            <button class="button">Перейти к оформлению</button>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

    <?php include_once('./footer.php'); ?>

    <script src="./assets/styles/blocks/input-count/input-count.js">
    </script>
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