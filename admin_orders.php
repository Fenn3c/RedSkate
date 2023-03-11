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

$orders = $db->getOrders();
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
                    Заказы
                </h2>

                <div class="product__breadcrumb">
                    <a href="./admin.php" class="link">Панель администратора</a>
                </div>

                <table class="table">
                    <tr class="table__row">
                        <th class="table__header">
                            Номер №
                        </th>
                        <th class="table__header">
                            Телефон
                        </th>
                        <th class="table__header">
                            Почта
                        </th>
                        <th class="table__header">
                            Адрес
                        </th>

                        <th class="table__header">
                            Способ доставки
                        </th>
                        <th class="table__header">
                            Способ оплаты
                        </th>

                        <th class="table__header">Товары</th>

                        <th class="table__header">Статус</th>
                    </tr>
                    <?
                    $statuses = $db->getStatuses();
                    ?>
                    <? foreach ($orders as $order) : ?>
                        <?
                        $order_products = $db->getOrderProducts($order['id_order']);
                        ?>
                        <tr class="table__row">

                            <td class="table__item">
                                <?= $order['id_order'] ?>
                            </td>
                            <td class="table__item">
                                <?= $order['phone'] ?>
                            </td>
                            <td class="table__item">
                                <?= $order['email'] ?>
                            </td>
                            <td class="table__item">
                                <?= $order['address'] ?>
                            </td>
                            <td class="table__item">
                                <?= $order['delivery_method'] ?>
                            </td>
                            <td class="table__item">
                                <?= $order['pay_method'] ?>
                            </td>
                            <td class="table__item">
                                <div class="table__links">

                                    <ul>

                                        <? foreach ($order_products as $order_product) : ?>
                                            <li>
                                                <a href="./product.php?id_product=<?= $order_product['id_product'] ?>" class="link"><?= $order_product['name'] ?></a>
                                            </li>
                                        <? endforeach; ?>
                                    </ul>
                                </div>
                            </td>
                            <td class="table__item">
                                <form action="./actions/change_order_status.php" name="status_change" class="autosubmit" method="post">
                                    <input type="hidden" name="id_order" value="<?= $order['id_order'] ?>">
                                    <select name="id_order_status" id="status-select">
                                        <? foreach ($statuses as $status) : ?>
                                            <option value="<?= $status['id_order_status'] ?>" <?= $status['id_order_status'] == $order['id_order_status'] ? 'selected' : '' ?>><?= $status['status'] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </form>
                            </td>

                        </tr>
                    <? endforeach; ?>
                </table>

        </div>
        </section>
    </main>

    <?php include_once('./footer.php'); ?>
    <script src="./assets/scripts/autosubmit.js">
    </script>
    <script>
        autoSubmitConfirm("Вы уверены, что хотите изменить статус заказа?");
    </script>
</body>

</html>