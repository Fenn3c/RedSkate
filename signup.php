<?php
require_once('./utils/sessionManager/sessionManager.php');
$sessionManager = new SessionManager();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - RedSkate</title>
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>

    <?php include_once('./header.php'); ?>
    <main class="main main_main-page">
        <div class="main__wrap">
            <div class="authentication">
                <h1 class="authentication__title">Регистрация</h1>
                <p class="error"><?= $sessionManager->getSessionField('REGISTRATION_ERROR') ?></p>
                <? $sessionManager->clearSessionField('REGISTRATION_ERROR'); ?>
                <form class="authentication__form" method="post" action="./actions/signup.php" id="signup-form">
                    <div class="input">
                        <label class="input__label" for="name">Имя пользователя<span class="input__label-required">*</span></label>
                        <input type="text" class="input__input" name="name" id="name" placeholder="Имя пользователя" required>
                    </div>
                    <div class="input">
                        <label class="input__label" for="email">Почта<span class="input__label-required">*</span></label>
                        <input type="email" class="input__input" name="email" id="email" placeholder="Почта" required>
                    </div>
                    <div class="input">
                        <label class="input__label" for="password">Пароль<span class="input__label-required" required>*</span></label>
                        <input type="password" class="input__input" name="password" id="password" placeholder="Пароль" required>
                    </div>
                    <div class="input">
                        <label class="input__label" for="password_repeat">Повтор пароля<span class="input__label-required">*</span></label>
                        <input type="password" class="input__input" name="password_repeat" id="password_repeat" placeholder="Повтор пароля" required>
                    </div>
                    <label class="checkbox__label">
                        <input type="checkbox" class="checkbox" id="tos" name="tos" required>
                        <span class="checkbox__label">Я согласен с&nbsp;<a class="link link_underline" href="#">
                                уловиями
                                пользовательского соглашения</a></span>
                    </label>
                    <button class="button" type="submit" id="signup-btn" disabled>Зарегистрироваться</button>
                    <a href="./signin.php" class="link">Уже есть аккаунт?</a>
                </form>
            </div>
        </div>
    </main>


    <?php include_once('./footer.php'); ?>
    <script src="./assets/scripts/form-check.js">
    </script>
    <script>
        formCheck(document.getElementById('signup-form'), document.getElementById('signup-btn'));
    </script>
</body>

</html>