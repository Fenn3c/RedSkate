<?php
require_once('./utils/database/database.php');
require_once('./utils/sessionManager/sessionManager.php');
require_once('./utils/middlewares/sessionMiddleware.php');
require_once('./utils/formaters/format_price.php');
require_once('./utils/formaters/get_discount.php');
$db = new Database();
$sessionManager = new SessionManager();
$sessionMiddleware = new SessionMiddleware($sessionManager, './index.php');
$sessionMiddleware->onlyAdmin();

$categories = $db->getCategories();
if (!isset($_GET['id_product'])) {
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
        header("Location: ./index.php");
    }
}

$id_product = (int)$_GET['id_product'];
$product = $db->getProductById($id_product);

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование товара - RedSkate</title>
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>

<body>
    <?php include_once('./header.php'); ?>
    <main class="main main_main-page">
        <div class="main__wrap">
            <section class="create-product">
                <form action="./actions/edit_product.php" class="create-product__form" id="create-product-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_product" value="<?= $id_product ?>">
                    <div>
                        <h2 class="title">Изменение товара</h2>

                        <h3 class="title_small title_no-margin">Данные товара</h3>
                    </div>
                    <div class="input">
                        <label class="input__label" for="name">Название<span class="input__label-required">*</span></label>
                        <input type="text" class="input__input" name="name" id="name" placeholder="Название товара" value="<?= $product['name'] ?>" required>
                    </div>
                    <div class="create-product__inputs-row">
                        <div class="input">
                            <label class="input__label" for="price">Цена<span class="input__label-required">*</span></label>
                            <input type="number" class="input__input" name="price" id="price" value="<?= $product['price'] ?>" placeholder="Цена" required>
                        </div>
                        <div class="input">
                            <label class="input__label" for="old-price">Цена без скидки</label>
                            <input type="text" class="input__input" name="old-price" id="old-price" value="<?= $product['old_price'] ?>" placeholder="Цена без скидки">
                        </div>
                    </div>
                    <div class="input">
                        <label class="input__label" for="description">Описание товара<span class="input__label-required">*</span></label>
                        <textarea class="input__input" name="description" id="description" cols="30" rows="10" placeholder="Описание товара" required><?= $product['description'] ?></textarea>
                    </div>


                    <label class="input__label" for="count">Количество экзмпляров<span class="input__label-required">*</span></label>
                    <div class="input-count">
                        <button type="button" class="input-count__btn input-count__dec">-</button>
                        <input id="count" name="count" class="input-count__input" type="number" min="1" max="100" value="<?= $product['count'] ?>" required>
                        <button type="button" class="input-count__btn input-count__inc">+</button>
                    </div>

                    <div class="checkbox-group">
                        <p class="checkbox-group__title">Пометить как</p>
                        <label class="checkbox__label">
                            <input type="checkbox" class="checkbox" name="new" <?= $product['new'] ? 'checked' : '' ?>>
                            <span class="checkbox__label">Новинка</span>
                        </label>
                        <label class="checkbox__label">
                            <input type="checkbox" class="checkbox" name="bestseller" <?= $product['bestseller'] ? 'checked' : '' ?>>
                            <span class="checkbox__label">Хит продаж</span>
                        </label>
                    </div>
                    <div class="checkbox-group">
                        <p class="checkbox-group__title">Категория</p>
                        <? foreach ($categories as $category) : ?>
                            <label class="checkbox__label">
                                <input name="id_category" id="category-<?= $category['id_category'] ?>" value="<?= $category['id_category'] ?>" type="radio" class="checkbox" <?= $category['id_category'] == $product['id_category'] ? 'checked' : '' ?>>
                                <span class="checkbox__label"><?= $category['name'] ?></span>
                            </label>
                        <? endforeach; ?>
                    </div>

                    <div class="color-picker">
                        <input class="color-picker__input" type="color" id="color" name="color" value="<?= $product['color'] ?>" required>
                        <label class="color-picker__lable" for="color">Цвет фона</label>
                    </div>

                    <div class="create-product__inputs-row">
                        <div>
                            <h3 class="title_small">Изменить превью изображение</h3>
                            <input class="create-product__image-input button" type="file" name="preview" id="product-preview-input">
                        </div>
                        <img class="create-product__preview-img" src="./assets/img/png/product-img.png" alt="" id="product-preview">
                    </div>
                    <h3 class="title_small">Изменить изображения товара</h3>
                    <input class="create-product__image-input button" type="file" name="images[]" id="product-gallery-input" multiple="multiple">

                    <div class="product__gallery">
                        <button class="product__gallery-btn" id="slider-left" type="button">
                            <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.53125 19.2868L0.481251 11.2368C0.306251 11.0618 0.182585 10.8722 0.110251 10.668C0.0367512 10.4639 0 10.2451 0 10.0118C0 9.77844 0.0367512 9.55969 0.110251 9.35552C0.182585 9.15135 0.306251 8.96177 0.481251 8.78677L8.53125 0.736771C8.85208 0.415938 9.25283 0.247938 9.7335 0.232772C10.2153 0.218772 10.6313 0.386771 10.9813 0.736771C11.3021 1.0576 11.4625 1.46594 11.4625 1.96177C11.4625 2.4576 11.3021 2.86594 10.9813 3.18677L4.2 10.0118L10.9813 16.8368C11.3021 17.1576 11.4695 17.5584 11.4835 18.039C11.4987 18.5209 11.3313 18.9368 10.9813 19.2868C10.6604 19.6076 10.2521 19.768 9.75625 19.768C9.26042 19.768 8.85208 19.6076 8.53125 19.2868Z" fill="black" />
                            </svg>
                        </button>

                        <div class="product__gallery-slider" id="slider">
                        </div>

                        <button class="product__gallery-btn" id="slider-right" type="button">
                            <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.46875 0.713231L11.5187 8.76323C11.6937 8.93823 11.8174 9.12781 11.8897 9.33198C11.9632 9.53615 12 9.7549 12 9.98823C12 10.2216 11.9632 10.4403 11.8897 10.6445C11.8174 10.8486 11.6937 11.0382 11.5187 11.2132L3.46875 19.2632C3.14792 19.5841 2.74717 19.7521 2.2665 19.7672C1.78467 19.7812 1.36875 19.6132 1.01875 19.2632C0.697916 18.9424 0.537497 18.5341 0.537497 18.0382C0.537497 17.5424 0.697916 17.1341 1.01875 16.8132L7.8 9.98823L1.01875 3.16323C0.697915 2.8424 0.530497 2.44165 0.516497 1.96098C0.50133 1.47915 0.668748 1.06323 1.01875 0.713232C1.33958 0.392398 1.74791 0.231979 2.24375 0.231979C2.73958 0.231979 3.14791 0.392398 3.46875 0.713231Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <button type="submit" id="create-product-btn" class="button" disabled>Изменить</button>
                </form>
                <div class="create-product__preview">
                    <h3 class="title-small">Предпросмотр товара</h3>
                    <div class="products__list-item product-card">
                        <div class="product-card__bg" id="color-preview" style="background-color: <?= $product['color'] ?>">
                            <p class="product-card__discount" id="old-price-preview" <?= $product['old_price'] ? '' : 'hidden' ?>><?= get_discount($product['price'], $product['old_price']) ?></p>
                            <a href="#" class="product-card__link">
                                <img src="./data/product-preview/<?= $product['preview'] ?>" alt="" class="product-card__img" id="preview-img">
                            </a>
                        </div>

                        <a href="#" class="product-card__link">
                            <p class="product-card__title" id="preview-name"><?= $product['name'] ?></p>
                        </a>
                        <div class="product-card__rating rating">
                            <span class="rating__star"></span>
                            <span class="rating__star"></span>
                            <span class="rating__star"></span>
                            <span class="rating__star"></span>
                            <span class="rating__star__half"></span>
                            <span class="rating__count">1,2k</span>
                        </div>
                        <div class="product-card__bottom">
                            <span class="product-card__price" id="preview-price"><?= format_price($product['price']) ?></span>
                            <span class="product-card__price_crossed" id="preview-old-price" <?= $product['old_price'] ? '' : 'hidden' ?>><?= format_price($product['old_price']) ?></span>
                            <div class="product-card__actions">
                                <form action="">
                                    <button class="product-card__action">
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

                                    <button class="product-card__action">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 22C6.45 22 5.97933 21.8043 5.588 21.413C5.196 21.021 5 20.55 5 20C5 19.45 5.196 18.979 5.588 18.587C5.97933 18.1957 6.45 18 7 18C7.55 18 8.02067 18.1957 8.412 18.587C8.804 18.979 9 19.45 9 20C9 20.55 8.804 21.021 8.412 21.413C8.02067 21.8043 7.55 22 7 22ZM17 22C16.45 22 15.9793 21.8043 15.588 21.413C15.196 21.021 15 20.55 15 20C15 19.45 15.196 18.979 15.588 18.587C15.9793 18.1957 16.45 18 17 18C17.55 18 18.021 18.1957 18.413 18.587C18.8043 18.979 19 19.45 19 20C19 20.55 18.8043 21.021 18.413 21.413C18.021 21.8043 17.55 22 17 22ZM7 17C6.25 17 5.68333 16.6707 5.3 16.012C4.91667 15.354 4.9 14.7 5.25 14.05L6.6 11.6L3 4H1.975C1.69167 4 1.45833 3.904 1.275 3.712C1.09167 3.52067 1 3.28333 1 3C1 2.71667 1.096 2.479 1.288 2.287C1.47933 2.09567 1.71667 2 2 2H3.625C3.80833 2 3.98333 2.05 4.15 2.15C4.31667 2.25 4.44167 2.39167 4.525 2.575L5.2 4H19.95C20.4 4 20.7083 4.16667 20.875 4.5C21.0417 4.83333 21.0333 5.18333 20.85 5.55L17.3 11.95C17.1167 12.2833 16.875 12.5417 16.575 12.725C16.275 12.9083 15.9333 13 15.55 13H8.1L7 15H18.025C18.3083 15 18.5417 15.0957 18.725 15.287C18.9083 15.479 19 15.7167 19 16C19 16.2833 18.904 16.5207 18.712 16.712C18.5207 16.904 18.2833 17 18 17H7Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
        </section>
    </main>


    <?php include_once('./footer.php'); ?>

    <script>
        const previewName = document.getElementById('preview-name')
        const title = document.getElementById('name')

        const previewPrice = document.getElementById('preview-price')
        const price = document.getElementById('price')

        const previewDiscountPrice = document.getElementById('preview-old-price')
        const oldPrice = document.getElementById('old-price')
        const oldPreview = document.getElementById('old-price-preview')

        const colorPreview = document.getElementById('color-preview')
        const color = document.getElementById('color')




        oldPrice.addEventListener('input', (e) => {
            if (e.target.value == '') {
                previewDiscountPrice.hidden = true
                oldPreview.hidden = true
            } else {
                previewDiscountPrice.hidden = false
                oldPreview.hidden = false
                previewDiscountPrice.innerText = `${Number(e.target.value).toLocaleString()} ₽`;
                oldPreview.innerText = `${- (100 - Math.round(( Number(price.value) /Number(e.target.value)) *100))}%`;
            }
        })


        color.addEventListener('input', (e) => {
            colorPreview.style.backgroundColor = e.target.value;
        })

        price.addEventListener('input', (e) => {
            previewPrice.innerText = `${Number(e.target.value).toLocaleString()} ₽`;
        })

        title.addEventListener('input', (e) => {
            previewName.innerText = e.target.value
        })
    </script>
    <script src="./assets/scripts/form-check.js">
    </script>
    <script>
        formCheck(document.getElementById('create-product-form'), document.getElementById('create-product-btn'));
    </script>

    <script src="./assets/styles/blocks/input-count/input-count.js"></script>
    <script src="./assets/styles/blocks/product/product-gallery.js"></script>
    <script>
        document.getElementById('product-preview-input').onchange = function(evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            // FileReader support
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function() {
                    document.getElementById('product-preview').src = fr.result;
                    document.getElementById('preview-img').src = fr.result;

                }
                fr.readAsDataURL(files[0]);
            }
        }
    </script>
    <script>
        const productGallerySlider = document.getElementById('slider')
        document.getElementById('product-gallery-input').onchange = function(evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            // FileReader support
            if (FileReader && files && files.length) {

                for (let i = 0; i < files.length; i++) {
                    const fr1 = new FileReader();
                    fr1.onload = function() {
                        const img = document.createElement('img')
                        img.src = fr1.result;
                        img.classList.add('product__gallery-img')
                        slider.appendChild(img);
                        // document.getElementById('product-preview').src = fr.result;
                    }
                    console.log(files)
                    fr1.readAsDataURL(files[i]);
                }
            }
        }
    </script>
</body>

</html>