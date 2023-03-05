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
                <div class="profile__card">
                    <img class="profile__pfp" src="./assets/img/png/user-default.png" alt="userpfp">
                    <div class="profile__card-inputs">
                        <div class="input">
                            <label class="input__label" for="username"></label>
                            <input type="text" class="input__input" name="username" id="username" placeholder="Имя пользователя" required>
                        </div>
                        <div class="input">
                            <label class="input__label" for="email"></label>
                            <input type="email" class="input__input" name="email" id="email" placeholder="Почта" required>
                        </div>

                        <div class="input">
                            <label class="input__label" for="phone"></label>
                            <input type="tel" class="input__input" name="phone" id="phone" placeholder="Номер телефона" required>
                        </div>

                        <div class="input">
                            <label class="input__label" for="address"></label>
                            <input type="text" class="input__input" name="address" id="address" placeholder="Адрес" required>
                        </div>

                    </div>
                </div>
            </section>

            <section class="products">
                <h2 class="products__title title">Мои заказы</h2>
                <div class="products__list">
                    <div class="products__list-item product-card">
                        <div class="product-card__bg">
                            <a href="#" class="product-card__link">
                                <img src="./assets/img/png/product-img.png" alt="" class="product-card__img">
                            </a>
                        </div>

                        <a href="#" class="product-card__link">
                            <p class="product-card__title">Скейтборд в сборе Footwork Waves 8”</p>
                        </a>
                        <div class="product-card__order-info">
                            <span class="product-card__order-yellow">Ожидание доставки</span>
                        </div>
                        <div class="product-card__bottom">
                            <span class="product-card__price">5 243 ₽</span>

                        </div>
                    </div>
                    <div class="products__list-item product-card">
                        <div class="product-card__bg">
                            <a href="#" class="product-card__link">
                                <img src="./assets/img/png/product-img.png" alt="" class="product-card__img">
                            </a>
                        </div>

                        <a href="#" class="product-card__link">
                            <p class="product-card__title">Скейтборд в сборе Footwork Waves 8”</p>
                        </a>
                        <div class="product-card__order-info">
                            <span class="product-card__order-green">Выполнен</span>
                            <a href="#" class="link link_underline">Оставить отзыв</a>
                        </div>
                        <div class="product-card__bottom">
                            <span class="product-card__price">5 243 ₽</span>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>


    <?php include_once('./footer.php'); ?>
</body>

</html>