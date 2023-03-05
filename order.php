<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - RedSkate</title>
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>
    <?php include_once('./header.php'); ?>
    <main class="main main_main-page">
        <div class="main__wrap">
            <form action="" class="order__form" id="order-form">
                <h2 class="title">Оформление заказа</h2>

                <h3 class="title_small">Данные покупателя</h3>
                <div class="order__row-inputs">

                    <div class="input">
                        <label class="input__label" for="phone">Телефон<span class="input__label-required">*</span></label>
                        <input type="tel" class="input__input" name="phone" id="phone" placeholder="Телефон" required>
                    </div>
                    <div class="input">
                        <label class="input__label" for="email">Почта<span class="input__label-required">*</span></label>
                        <input type="email" class="input__input" name="email" id="email" placeholder="Почта" required>
                    </div>
                </div>

                <h3 class="title_small">Способ получения</h3>


                <div class="order__row-inputs">
                    <label class="radio__label">
                        <input type="radio" class="radio" name="delivery-method" id="pickup-radio" required checked>
                        <span class="radio__label">Самовывоз</span>
                    </label>

                    <label class="radio__label">
                        <input type="radio" class="radio" name="delivery-method" id="delivery-radio" required>
                        <span class="radio__label">Доставка</span>
                    </label>
                </div>

                <div class="order__row-inputs">
                    <div class="input input_hidden" id="address-block">
                        <label class="input__label" for="address">Адрес доставки<span class="input__label-required">*</span></label>
                        <input type="text" class="input__input" name="address" id="address" placeholder="Улица, дом, этаж, квартира" required>
                    </div>
                </div>

                <h3 class="title_small">Способ оплаты</h3>
                <div class="order__row-inputs">
                    <label class="radio__label">
                        <input type="radio" class="radio" name="pay-method" required checked>
                        <span class="radio__label">При получении</span>
                    </label>

                    <label class="radio__label">
                        <input type="radio" class="radio" name="pay-method" required>
                        <span class="radio__label">Онлайн</span>
                    </label>
                </div>
                <button class="button" id="order-btn" disabled>Подтвердить заказ</button>
            </form>
        </div>
    </main>

    <?php include_once('./footer.php'); ?>


    <script src="./assets/scripts/form-check.js">
    </script>
    <script>
        formCheck(document.getElementById('order-form'), document.getElementById('order-btn'));
    </script>
    <script>
        const deliveryRadio = document.getElementById('delivery-radio')
        const pickupRadio = document.getElementById('pickup-radio')
        const addressInput = document.getElementById('address')
        const addressBlock = document.getElementById('address-block')

        function check() {
            if (deliveryRadio.checked) {
                addressInput.required = true
                addressBlock.classList.remove('input_hidden');
            } else {
                addressInput.required = false
                addressBlock.classList.add('input_hidden');

            }
        }

        deliveryRadio.addEventListener('click', () => {
            check()
        })
        pickupRadio.addEventListener('click', () => {
            check()
        })
    </script>
</body>

</html>