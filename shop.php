<?php
require_once('./utils/database/database.php');
require_once('./utils/formaters/format_price.php');
require_once('./utils/formaters/get_discount.php');
require_once('./utils/sessionManager/sessionManager.php');

const PRODUCTS_PER_PAGE = 9;

$db = new Database();
$sessionManager = new SessionManager();
$id_user = $sessionManager->idUser();
$sql = '';
$sql_values = [];

if (!isset($_GET['available']) && !isset($_GET['n-available'])) {
    // не то не то
    $sql = $sql . ' AND products.count > 0';
} else if (isset($_GET['available']) && !isset($_GET['n-available'])) {
    // доступно
    $sql = $sql . ' AND products.count > 0';
} else if (!isset($_GET['available']) && isset($_GET['n-available'])) {
    // нет в наличии
    $sql = $sql . ' AND products.count = 0';
}

if (isset($_GET['rating-more-4'])) {
    $sql = $sql . ' AND (SELECT AVG(rating) from reviews WHERE reviews.id_product = products.id_product) >= 4';
}

if (isset($_GET['sale'])) {
    $sql = $sql . ' AND old_price IS NOT NULL';
}
if (isset($_GET['id_category'])) {
    $sql = $sql . ' AND products.id_category IN (' . implode(',', $_GET['id_category']) . ')';
}
if (isset($_GET['min']) && isset($_GET['max'])) {
    $sql = $sql . ' AND products.price BETWEEN :minPrice and :maxPrice';
    $sql_values = $sql_values +  array(
        "minPrice" => $_GET['min'],
        "maxPrice" => $_GET['max']
    );
}
if (isset($_GET['search'])) {
    $search = trim(strip_tags($_GET['search']));
    $sql = $sql . ' AND products.name LIKE :search OR products.description LIKE :search';
    $sql_values = $sql_values + array(
        "search" => "%$search%"
    );
}

$sort = $_GET['sort'] ?? 'lprice';
switch ($sort) {
    case 'hprice':
        $sql = $sql . ' ORDER BY price DESC';
        break;
    case 'lprice':
        $sql = $sql . ' ORDER BY price ASC';
        break;
    case 'review':
        $sql = $sql . ' ORDER BY (SELECT AVG(rating) from reviews WHERE reviews.id_product = products.id_product) DESC';
        break;
}


$products = $db->getProductsWithFilters($sql, $sql_values);
$minMax = $db->getMinMaxWithFilters($sql, $sql_values);
$min =  $minMax['min'];
$max =  $minMax['max'];
if (isset($_GET['min']) && isset($_GET['max'])) {
    $min = (int)$_GET['min'];
    $max = (int)$_GET['max'];
}


$page = 1;
$totalProducts = count($products);
$countPages = (int)ceil($totalProducts / PRODUCTS_PER_PAGE);

$page = $_GET['page'] ?? 1;
if (!$page || $page < 1) {
    $page = 1;
}
if ($page > $countPages) {
    $page = $countPages;
}

$start =  ($page - 1) * PRODUCTS_PER_PAGE;

$pageProducts = array_slice($products, $start, PRODUCTS_PER_PAGE);


$categories = $db->getCategories();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="скейтборд +в москве, скейтборд разные, скейтборд +с удлиненной базой, дека +для скейтборда, колесная база скейтборда, летающий скейтборд, части скейтборда, включи скейтборд, скейтборд +с удлиненной колесной, колеса +для скейтборда, размеры скейтборда, скейтборд 6 лет, база скейтборды, можно скейтборды, скейтборды 4, удлиненный скейтборд, скейтборд 8, колесный скейтборд, скейтборд фильм, катание +на скейтборде, трюки +на скейтборде, скейтборд 12 лет, скейтборд +для начинающих, сколько стоит скейтборд, +как выбрать скейтборд, скейтборд купить, фингерборд, спортинвентарь, скейтбординг, ске, скейтер алена, скейтер песня, демон стрит, баланс борда, пенни борда, борд купить, купить борда, ru board, фингерборд, катание +на сноуборде, скейтборд, сноуборд, скейтер, стрит, skate," />
    <meta name="description" content="Интернет-магазин предлагает широкий выбор скейтбордов для любителей экстремальных видов спорта. У нас вы найдете качественные модели от ведущих производителей по доступным ценам. Мы гарантируем быструю доставку и высокий уровень сервиса. Покупайте скейтборды у нас и наслаждайтесь яркими эмоциями от катания!" />
    <title>Магазин - RedSkate</title>
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>

    <?php include_once('./header.php'); ?>

    <main class="main main_main-page">
        <form action="" method="get">

            <div class="main__wrap main__wrap_horizontal">
                <aside class="filter">
                    <div method="get" class="filter__form autosubmit">
                        <div class="filter__section">
                            <p class="filter__title">Наличие</p>
                            <label class="checkbox__label">
                                <input name="available" type="checkbox" class="checkbox" <?php
                                                                                            if (
                                                                                                !isset($_GET['available']) && !isset($_GET['n-available'])
                                                                                                || isset($_GET['available']) && !isset($_GET['n-available']) ||
                                                                                                isset($_GET['available']) && isset($_GET['n-available'])
                                                                                            ) :
                                                                                            ?> checked <? endif; ?>>
                                <span class="checkbox__label">В наличии</span>
                            </label>
                            <label class="checkbox__label">
                                <input name="n-available" type="checkbox" class="checkbox" <?= isset($_GET['n-available']) ? 'checked' : '' ?>>
                                <span class="checkbox__label">Нет в наличии</span>
                            </label>
                        </div>
                        <div class="filter__section">
                            <p class="filter__title">Рейтинг</p>
                            <label class="checkbox__label">
                                <input name="rating-more-4" type="checkbox" class="checkbox" <?= isset($_GET['rating-more-4']) ? 'checked' : '' ?>>
                                <span class="checkbox__label">Рейтинг 4 и выше</span>
                            </label>
                        </div>
                        <div class="filter__section">
                            <p class="filter__title">Цена</p>

                            <div class="price-filter">
                                <!-- <div class="price-filter__ranges">
                                <input type="range" class="price-filter__range-min price-filter__range" min="<?= $min ?>" max="<?= $max ?>" value="<?= $min ?>">
                                <input type="range" class="price-filter__range-max price-filter__range" min="<?= $min ?>" max="<?= $max ?>" value="<?= $max ?>">
                            </div>
                            <div class="price-filter__slider">
                                <div class="price-filter__progress"></div>
                            </div> -->
                                <div class="price-filter__inputs">
                                    <div class="price-filter__text">
                                        От (₽)
                                    </div>
                                    <div class="price-filter__text">До (₽)</div>
                                </div>
                                <div class="price-filter__inputs">
                                    <label class="input">
                                        <input type="number" class="input__input input__input_mini price-filter__input-min" id="min" name="min" placeholder="от <?= $min ?>" value="<?= $min ?>">
                                    </label>
                                    <label class="input">
                                        <input type="number" class="input__input input__input_mini price-filter__input-max" id="max" name="max" placeholder="до <?= $max ?>" value="<?= $max ?>">
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="filter__section">
                            <p class="filter__title">Акция</p>
                            <label class="checkbox__label">
                                <input name="sale" type="checkbox" class="checkbox" <?= isset($_GET['sale']) ? 'checked' : '' ?>>
                                <span class="checkbox__label">Участвует в акции</span>
                            </label>
                        </div>
                        <div class="filter__section">
                            <p class="filter__title">Категория</p>
                            <? foreach ($categories as $category) : ?>
                                <label class="checkbox__label">
                                    <input type="checkbox" class="checkbox" value="<?= $category['id_category'] ?>" name="id_category[<?= $category['id_category'] ?>]" <?= isset($_GET['id_category']) && in_array($category['id_category'], $_GET['id_category']) ? 'checked' : '' ?>>
                                    <span class="checkbox__label"><?= $category['name'] ?></span>
                                </label>
                            <? endforeach; ?>
                        </div>
                        <button class="button filter__btn" type="submit">Показать</button>
                        <a href="./shop.php" class="link">Сбросить</a>
                    </div>
                </aside>
                <div class="">
                    <section class="products">
                        <div class="products__title-wrap">
                            <h2 class="products__title products__title_no-margin">
                                Мы нашли следующие товары для вас
                            </h2>
                            <div class="products__sorting drop-menu">
                                Сортировка:

                                <span class="link">
                                    <? switch ($sort):
                                        case 'hprice': ?>
                                            Сначала дорогие
                                            <? break; ?>
                                        <?
                                        case 'review': ?>
                                            Сначала с оценкой
                                            <? break; ?>
                                        <?
                                        default: ?>
                                            Сначала недорогие
                                            <? break; ?>

                                    <? endswitch; ?>
                                </span>
                                <ul class="drop-menu__list drop-menu__list_hidden">
                                    <li class="drop-menu__item">
                                        <button type="submit" class="link link_btn" name="sort" value="hprice">Сначала дорогие</button>
                                    </li>
                                    <li class="drop-menu__item">
                                        <button type="submit" class="link link_btn" name="sort" value="lprice">Сначала недорогие</button>
                                    </li>
                                    <li class="drop-menu__item">
                                        <button type="submit" class="link link_btn" name="sort" value="review">Сначала оценкой</button>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="products__list products__list_triple">
                            <? foreach ($pageProducts as $product) : ?>
                                <div class="products__list-item product-card">
                                    <div class="product-card__bg" style="background-color: <?= $product['color'] ?>">

                                        <? if ($product['old_price']) : ?>
                                            <p class="product-card__discount"><?= get_discount($product['price'], $product['old_price']) ?></p>
                                        <? endif; ?>
                                        <a href="./product.php?id_product=<?= $product['id_product'] ?>" class="product-card__link">
                                            <img src="./data/product-preview/<?= $product['preview'] ?>" alt="" class="product-card__img">
                                        </a>
                                    </div>

                                    <a href="#" class="product-card__link">
                                        <p class="product-card__title"><?= $product['name'] ?></p>
                                    </a>

                                    <?
                                    $rating = $db->getProductRating($product['id_product']);
                                    ?>
                                    <div class="product-card__rating rating">
                                        <? for ($i = 0; $i < (int)$rating; $i++) : ?>
                                            <span class="rating__star"></span>
                                        <? endfor ?>
                                        <? if ($rating - (int)$rating) : ?>
                                            <span class="rating__star__half"></span>
                                        <? endif ?>

                                        <? for ($i = 0; $i < 5 - ceil($rating); $i++) : ?>
                                            <span class="rating__star__empty"></span>
                                        <? endfor ?>
                                        <span class="rating__count"><?= $db->getProductRatingCount($product['id_product']) ?></span>
                                    </div>

                                    <div class="product-card__bottom">
                                        <span class="product-card__price"><?= format_price($product['price']) ?></span>
                                        <?
                                        if ($product['old_price']) :
                                        ?>
                                            <span class="product-card__price_crossed"><?= format_price($product['old_price']) ?></span>
                                        <? endif; ?>
                                        <div class="product-card__actions">
                                            <form action="./actions/add_to_favourites.php" method="post" class="">
                                                <?php
                                                $isInFavourite = false;
                                                $isInCart = false;
                                                if ($id_user) {
                                                    $isInFavourite = $db->isInFavourites($id_user, $product['id_product']);
                                                    $isInCart = $db->isInCart($id_user, $product['id_product']);
                                                }
                                                ?>
                                                <input type="hidden" value="<?= $product['id_product'] ?>" name="id_product">
                                                <button class="product-card__action <?= $isInFavourite ? 'product-card__action_active' : '' ?>" type="submit">
                                                    <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <mask id="mask0_48_1274" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="22">
                                                            <path d="M7.5 2C4.4625 2 2 4.4625 2 7.5C2 13 8.5 18 12 19.163C15.5 18 22 13 22 7.5C22 4.4625 19.5375 2 16.5 2C14.64 2 12.995 2.9235 12 4.337C11.4928 3.6146 10.8191 3.02505 10.0358 2.61824C9.25245 2.21144 8.38265 1.99938 7.5 2Z" fill="white" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 1.00724e-06C8.70351 -0.000622934 9.88947 0.288639 10.9575 0.843327C11.3239 1.03358 11.6726 1.25313 12.0007 1.49925C13.2533 0.558865 14.8116 1.00724e-06 16.5 1.00724e-06C20.6421 1.00724e-06 24 3.35793 24 7.5C24 11.0182 21.9531 14.1238 19.7336 16.3651C17.4948 18.6261 14.7342 20.362 12.6307 21.061C12.2212 21.197 11.7788 21.197 11.3693 21.061C9.26578 20.362 6.50523 18.6261 4.26635 16.3651C2.04692 14.1238 0 11.0182 0 7.5C0 3.3584 3.35717 0.000765496 7.49859 1.48408e-06M9.11399 4.39316C8.61586 4.13446 8.06272 3.9996 7.50141 4L7.5 4C5.56707 4 4 5.56707 4 7.5C4 9.48177 5.20308 11.6262 7.10865 13.5506C8.73154 15.1896 10.616 16.4145 12 17.0201C13.384 16.4145 15.2685 15.1896 16.8914 13.5506C18.7969 11.6262 20 9.48177 20 7.5C20 5.56707 18.4329 4 16.5 4C15.3179 4 14.2717 4.58432 13.6354 5.48823C13.2606 6.02074 12.65 6.33741 11.9987 6.337C11.3475 6.33659 10.7373 6.01916 10.3631 5.48618C10.0406 5.02678 9.61213 4.65186 9.11399 4.39316Z" fill="white" />
                                                        </mask>
                                                        <g mask="url(#mask0_48_1274)">
                                                            <path d="M0 -2H24V22H0V-2Z" />
                                                        </g>
                                                    </svg>
                                                </button>
                                            </form>

                                            <form action="./actions/add_to_cart.php" method="post">
                                                <input type="hidden" value="<?= $product['id_product'] ?>" name="id_product">
                                                <button class="product-card__action <?= $isInCart ? 'product-card__action_active' : '' ?>" type="submit">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7 22C6.45 22 5.97933 21.8043 5.588 21.413C5.196 21.021 5 20.55 5 20C5 19.45 5.196 18.979 5.588 18.587C5.97933 18.1957 6.45 18 7 18C7.55 18 8.02067 18.1957 8.412 18.587C8.804 18.979 9 19.45 9 20C9 20.55 8.804 21.021 8.412 21.413C8.02067 21.8043 7.55 22 7 22ZM17 22C16.45 22 15.9793 21.8043 15.588 21.413C15.196 21.021 15 20.55 15 20C15 19.45 15.196 18.979 15.588 18.587C15.9793 18.1957 16.45 18 17 18C17.55 18 18.021 18.1957 18.413 18.587C18.8043 18.979 19 19.45 19 20C19 20.55 18.8043 21.021 18.413 21.413C18.021 21.8043 17.55 22 17 22ZM7 17C6.25 17 5.68333 16.6707 5.3 16.012C4.91667 15.354 4.9 14.7 5.25 14.05L6.6 11.6L3 4H1.975C1.69167 4 1.45833 3.904 1.275 3.712C1.09167 3.52067 1 3.28333 1 3C1 2.71667 1.096 2.479 1.288 2.287C1.47933 2.09567 1.71667 2 2 2H3.625C3.80833 2 3.98333 2.05 4.15 2.15C4.31667 2.25 4.44167 2.39167 4.525 2.575L5.2 4H19.95C20.4 4 20.7083 4.16667 20.875 4.5C21.0417 4.83333 21.0333 5.18333 20.85 5.55L17.3 11.95C17.1167 12.2833 16.875 12.5417 16.575 12.725C16.275 12.9083 15.9333 13 15.55 13H8.1L7 15H18.025C18.3083 15 18.5417 15.0957 18.725 15.287C18.9083 15.479 19 15.7167 19 16C19 16.2833 18.904 16.5207 18.712 16.712C18.5207 16.904 18.2833 17 18 17H7Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <? endforeach; ?>

                        </div>
                    </section>


                    <? if ($totalProducts) : ?>
                        <div class="pagination">
                            <div class="pagination__form" action="">
                                <?
                                $previousPage = $page - 1 >= 1 ? $page - 1 : 1;
                                ?>
                                <button name="page" value="<?= $previousPage ?>" class="pagination__button"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.53125 19.0548L0.481251 11.0048C0.306251 10.8298 0.182585 10.6402 0.110251 10.4361C0.0367512 10.2319 0 10.0131 0 9.77981C0 9.54647 0.0367512 9.32772 0.110251 9.12356C0.182585 8.91939 0.306251 8.72981 0.481251 8.55481L8.53125 0.504807C8.85208 0.183974 9.25283 0.0159744 9.7335 0.000807695C10.2153 -0.0131923 10.6313 0.154807 10.9813 0.504807C11.3021 0.82564 11.4625 1.23397 11.4625 1.72981C11.4625 2.22564 11.3021 2.63397 10.9813 2.95481L4.2 9.77981L10.9813 16.6048C11.3021 16.9256 11.4695 17.3264 11.4835 17.8071C11.4987 18.2889 11.3313 18.7048 10.9813 19.0548C10.6604 19.3756 10.2521 19.5361 9.75625 19.5361C9.26042 19.5361 8.85208 19.3756 8.53125 19.0548Z" />
                                    </svg>

                                </button>
                                <? for ($i = 1; $i <= $countPages; $i++) :
                                ?>
                                    <button class="pagination__button <?= $page == $i ? 'pagination__button_active' : '' ?>" name="page" value="<?= $i ?>"><?= $i ?></a>
                                    <? endfor; ?>
                                    <?
                                    $nextPage = $page + 1 <= $countPages ? $page + 1 : $countPages;
                                    ?>
                                    <button class="pagination__button" name="page" value="<?= $i ?>">
                                        <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.95312 0.481328L11.0031 8.53133C11.1781 8.70633 11.3018 8.89591 11.3741 9.10008C11.4476 9.30424 11.4844 9.52299 11.4844 9.75633C11.4844 9.98966 11.4476 10.2084 11.3741 10.4126C11.3018 10.6167 11.1781 10.8063 11.0031 10.9813L2.95312 19.0313C2.63229 19.3522 2.23154 19.5202 1.75087 19.5353C1.26904 19.5493 0.853125 19.3813 0.503125 19.0313C0.182291 18.7105 0.0218721 18.3022 0.0218721 17.8063C0.021872 17.3105 0.182291 16.9022 0.503125 16.5813L7.28437 9.75633L0.503123 2.93133C0.18229 2.61049 0.0148722 2.20974 0.00087218 1.72908C-0.0142945 1.24724 0.153123 0.831329 0.503123 0.481328C0.823957 0.160495 1.23229 7.57597e-05 1.72812 7.57164e-05C2.22395 7.5673e-05 2.63229 0.160495 2.95312 0.481328Z" />
                                        </svg>

                                    </button>


                            </div>
                        </div>
                    <? else : ?>
                        <p>К сожалению, ничего не найдено</p>
                    <? endif; ?>
                </div>
            </div>
        </form>
    </main>

    <?php include_once('./footer.php'); ?>
    <script src="./assets/styles/blocks/price-filter/price-filter.js"></script>
    <script src="./assets/scripts/autosubmit.js">
    </script>
    <script src="./assets/styles/blocks/drop-menu/drop-menu.js">
    </script>
</body>

</html>