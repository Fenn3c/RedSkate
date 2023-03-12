<?php
class DataBase
{
    private $db;
    public function __construct()
    {
        $db_settings = parse_ini_file("database.config.ini");
        $dsn = "mysql:host=" . $db_settings['HOST'] . ";dbname=" . $db_settings['DB'] . ";charset=" . $db_settings['CHARSET'] . ";";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => true,
        ];
        $this->db = new PDO($dsn, $db_settings['USER'], $db_settings['PASSWORD'], $options);
    }

    public function getProducts()
    {
        $query = $this->db->prepare("SELECT products.*, categories.name as category_name FROM products LEFT JOIN categories ON products.id_category = categories.id_category");
        $query->execute();
        return $query->fetchAll();
    }

    public function getProductsWithFilters($sql, $values)
    {
        $query = $this->db->prepare("SELECT products.*, categories.name as category_name FROM products 
        LEFT JOIN categories ON products.id_category = categories.id_category WHERE 1=1" . $sql);
        $query->execute($values);
        return $query->fetchAll();
    }

    public function getProductsCountWithFilters($sql, $values)
    {
        $query = $this->db->prepare("SELECT COUNT(*) as count FROM products 
        LEFT JOIN categories ON products.id_category = categories.id_category WHERE 1=1" . $sql);
        $query->execute($values);
        return $query->fetch()['count'];
    }
    public function getMinMaxWithFilters($sql, $values)
    {
        $query = $this->db->prepare("SELECT min(products.price) as min, max(products.price) as max FROM products WHERE 1=1" . $sql);
        $query->execute($values);
        return $query->fetch();
    }

    public function getOrders()
    {
        $query = $this->db->prepare("SELECT orders.*,status,  order_delivery_method.method as delivery_method, order_pay_methods.method as pay_method FROM orders 

INNER JOIN order_delivery_method ON orders.id_order_delivery_method = order_delivery_method.id_order_delivery_method
INNER JOIN order_pay_methods ON orders.id_order_pay_method = order_pay_methods.id_order_pay_method
INNER JOIN order_statuses ON orders.id_order_status = order_statuses.id_order_status
ORDER BY id_order DESC");
        $query->execute();
        return $query->fetchAll();
    }
    public function getProductById($id_product)
    {
        $query = $this->db->prepare("SELECT * FROM products WHERE id_product =:id_product");
        $query->execute(array(
            "id_product" => $id_product
        ));
        return $query->fetch();
    }
    public function getCategoryById($id_category)
    {
        $query = $this->db->prepare("SELECT * FROM categories WHERE id_category =:id_category");
        $query->execute(array(
            "id_category" => $id_category
        ));
        return $query->fetch();
    }

    public function getFavouriteProducts($id_user)
    {
        $query = $this->db->prepare("SELECT * FROM favourites JOIN products on favourites.id_product = products.id_product WHERE id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user
        ));
        return $query->fetchAll();
    }

    public function getCartProducts($id_user)
    {
        $query = $this->db->prepare("SELECT 
        id_cart,
        cart.count as cart_count, cart.id_product, cart.id_user,
        name,
        price, old_price, description, preview, color, id_category, products.count as product_count, new, bestseller
         FROM cart JOIN products on cart.id_product = products.id_product WHERE id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user
        ));
        return $query->fetchAll();
    }
    public function getCartProductByCartId($id_cart)
    {
        $query = $this->db->prepare("SELECT 
        id_cart,
        cart.count as cart_count, cart.id_product, cart.id_user,
        name,
        price, old_price, description, preview, color, id_category, products.count as product_count, new, bestseller
         FROM cart JOIN products on cart.id_product = products.id_product WHERE id_cart=:id_cart");
        $query->execute(array(
            "id_cart" => $id_cart
        ));
        return $query->fetch();
    }



    public function getCategories()
    {
        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        return $query->fetchAll();
    }

    public function getBestSellingProducts()
    {
        $query = $this->db->prepare("SELECT * FROM products WHERE bestseller = TRUE");
        $query->execute();
        return $query->fetchAll();
    }

    public function getNewProducts()
    {
        $query = $this->db->prepare("SELECT * FROM products WHERE new = TRUE");
        $query->execute();
        return $query->fetchAll();
    }

    public function getProductRating($id_product)
    {
        $query = $this->db->prepare("SELECT AVG(rating) as rating from reviews WHERE id_product=:id_product");
        $query->execute(array(
            "id_product" => $id_product
        ));
        return $query->fetch()['rating'];
    }
    public function getReviewRating($id_review)
    {
        $query = $this->db->prepare("SELECT rating from reviews WHERE id_review=:id_review");
        $query->execute(array(
            "id_review" => $id_review
        ));
        return $query->fetch()['rating'];
    }
    public function getProductRatingCount($id_product)
    {
        $query = $this->db->prepare("SELECT count(rating) as rating from reviews WHERE id_product=:id_product");
        $query->execute(array(
            "id_product" => $id_product
        ));
        return $query->fetch()['rating'];
    }

    public function createTempUser($name)
    {
        $query = $this->db->prepare("INSERT INTO users(name) VALUES(:name)");
        $query->execute(array(
            "name" => $name
        ));
        return $this->db->lastInsertId();
    }

    public function addToFavourites($id_user, $id_product)
    {
        $query = $this->db->prepare("INSERT INTO favourites(id_user, id_product) VALUES(:id_user, :id_product)");
        $query->execute(array(
            "id_user" => $id_user,
            "id_product" => $id_product
        ));
        return $this->db->lastInsertId();
    }
    public function removeFromFavourites($id_favourite)
    {
        $query = $this->db->prepare("DELETE FROM favourites WHERE id_favourite=:id_favourite");
        $query->execute(array(
            "id_favourite" => $id_favourite
        ));
        return $this->db->lastInsertId();
    }

    public function isInFavourites($id_user, $id_product)
    {
        $query = $this->db->prepare("SELECT * from favourites WHERE id_product=:id_product AND id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user,
            "id_product" => $id_product
        ));
        return $query->fetch()['id_favourite'];
    }



    public function addToCart($id_user, $id_product)
    {
        $query = $this->db->prepare("INSERT INTO cart(id_user, id_product) VALUES(:id_user, :id_product)");
        $query->execute(array(
            "id_user" => $id_user,
            "id_product" => $id_product
        ));
        return $this->db->lastInsertId();
    }

    public function isInCart($id_user, $id_product)
    {
        $query = $this->db->prepare("SELECT * from cart WHERE id_product=:id_product AND id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user,
            "id_product" => $id_product
        ));
        return $query->fetch()['id_cart'];
    }
    public function removeFromCart($id_cart)
    {
        $query = $this->db->prepare("DELETE FROM cart WHERE id_cart=:id_cart");
        $query->execute(array(
            "id_cart" => $id_cart
        ));
    }

    public function clearCart($id_user)
    {
        $query = $this->db->prepare("DELETE FROM cart WHERE id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user
        ));
    }

    public function incCart($id_cart)
    {
        $query = $this->db->prepare("UPDATE cart SET count = count+1 WHERE id_cart = :id_cart;");
        $query->execute(array(
            "id_cart" => $id_cart
        ));
    }
    public function decCart($id_cart)
    {
        $query = $this->db->prepare("UPDATE cart SET count = count-1 WHERE id_cart = :id_cart;");
        $query->execute(array(
            "id_cart" => $id_cart
        ));
    }

    public function checkCartCorrect($id_user)
    {
        $query = $this->db->prepare("SELECT MIN(products.count >= cart.count) as correct from cart left join products on products.id_product = cart.id_product WHERE cart.id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user
        ));
        return $query->fetch()['correct'];
    }

    public function createOrder($id_user, $id_order_status, $id_order_delivery_method, $id_order_pay_method,  $phone, $email, $address)
    {
        $query = $this->db->prepare("
       INSERT INTO orders (id_user, id_order_status,id_order_delivery_method, id_order_pay_method, phone, email, address)
        VALUES (:id_user, :id_order_status,:id_order_delivery_method, :id_order_pay_method, :phone, :email, :address);
        ");
        $query->execute(array(
            "id_user" => $id_user,
            "id_order_status" => $id_order_status,
            "id_order_delivery_method" => $id_order_delivery_method,
            "id_order_pay_method" => $id_order_pay_method,
            "phone" => $phone,
            "email" => $email,
            "address" => $address
        ));
        return $this->db->lastInsertId();
    }

    public function addOrderProductsFromCart($id_order, $id_user)
    {
        $query = $this->db->prepare("
       INSERT INTO order_products(id_order, id_product, count, final_price) SELECT :id_order, cart.id_product, cart.count, price from cart 
       LEFT JOIN products ON products.id_product = cart.id_product WHERE cart.id_user = :id_user
        ");
        $query->execute(array(
            "id_order" => $id_order,
            "id_user" => $id_user,
        ));
    }
    public function getUserOrderProducts($id_user)
    {
        $query = $this->db->prepare("SELECT * FROM order_products LEFT JOIN orders ON order_products.id_order = orders.id_order
        LEFT JOIN products on order_products.id_product = products.id_product WHERE orders.id_user = :id_user");
        $query->execute(array(
            "id_user" => $id_user
        ));
        return $query->fetchAll();
    }

    public function getOrderProducts($id_order)
    {
        $query = $this->db->prepare("SELECT * FROM order_products LEFT JOIN orders ON order_products.id_order = orders.id_order
        LEFT JOIN products on order_products.id_product = products.id_product WHERE orders.id_order = :id_order");
        $query->execute(array(
            "id_order" => $id_order
        ));
        return $query->fetchAll();
    }

    public function getSimilarProducts($id_product)
    {
        $query = $this->db->prepare("SELECT * FROM products 
        WHERE id_category=(SELECT id_category FROM products WHERE products.id_product = :id_product) AND id_product != :id_product ORDER BY RAND() LIMIT 4");
        $query->execute(array(
            "id_product" => $id_product
        ));
        return $query->fetchAll();
    }
    public function getProductReviews($id_product)
    {
        $query = $this->db->prepare("SELECT * FROM reviews LEFT JOIN users ON reviews.id_user=users.id_user WHERE id_product = :id_product ");
        $query->execute(array(
            "id_product" => $id_product,
        ));
        return $query->fetchAll();
    }
    public function getProductImages($id_product)
    {
        $query = $this->db->prepare("SELECT * FROM product_images WHERE id_product=:id_product");
        $query->execute(array(
            "id_product" => $id_product,
        ));
        return $query->fetchAll();
    }

    public function canReview($id_user, $id_product)
    {
        $query = $this->db->prepare("SELECT COUNT(*) as count FROM order_products 
        LEFT JOIN orders ON orders.id_order = order_products.id_order LEFT JOIN users ON users.id_user = orders.id_user
WHERE orders.id_order_status = 5 AND orders.id_user = :id_user AND order_products.id_product = :id_product;");
        $query->execute(array(
            "id_user" => $id_user,
            "id_product" => $id_product
        ));
        return $query->fetch()['count'];
    }
    public function hasReview($id_user, $id_product)
    {
        $query = $this->db->prepare("SELECT COUNT(*) as count from reviews WHERE id_user=:id_user AND id_product=:id_product");
        $query->execute(array(
            "id_user" => $id_user,
            "id_product" => $id_product
        ));
        return $query->fetch()['count'];
    }
    public function createReview($id_user, $id_product, $text, $rating)
    {
        $query = $this->db->prepare("INSERT INTO reviews(id_user, id_product, text, rating) 
        VALUES (:id_user, :id_product, :text, :rating)");
        $query->execute(array(
            "id_user" => $id_user,
            "id_product" => $id_product,
            "text" => $text,
            "rating" => $rating
        ));
        return $this->db->lastInsertId();
    }

    public function getUserData($id_user)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user
        ));
        return $query->fetch();
    }

    public function getUserByName($name)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE name=:name");
        $query->execute(array(
            "name" => $name
        ));
        return $query->fetch();
    }
    public function getUserByEmail($email)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $query->execute(array(
            "email" => $email
        ));
        return $query->fetch();
    }

    public function createUser($name, $email, $password)
    {
        $query = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $query->execute(array(
            "name" => $name,
            "email" => $email,
            "password" => $password
        ));
        return $this->db->lastInsertId();
    }

    public function createUserFromTemp($id_user, $name, $email, $password)
    {
        $query = $this->db->prepare("UPDATE users SET name=:name, email=:email, password=:password WHERE id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user,
            "name" => $name,
            "email" => $email,
            "password" => $password
        ));
    }


    public function updateUserInfo($id_user, $name, $email, $phone, $address)
    {
        $query = $this->db->prepare("UPDATE users SET name=:name, email=:email, address=:address, phone=:phone WHERE id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user,
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "address" => $address,
        ));
    }
    public function updateUserPfp($id_user, $pfp)
    {
        $query = $this->db->prepare("UPDATE users SET pfp=:pfp WHERE id_user=:id_user");
        $query->execute(array(
            "id_user" => $id_user,
            "pfp" => $pfp
        ));
    }

    public function getStatuses()
    {
        $query = $this->db->prepare("SELECT * FROM order_statuses");
        $query->execute();
        return $query->fetchAll();
    }
    public function updateOrderStatus($id_order, $id_order_status)
    {
        $query = $this->db->prepare("UPDATE orders SET id_order_status=:id_order_status WHERE id_order=:id_order");
        $query->execute(array(
            "id_order" => $id_order,
            "id_order_status" => $id_order_status
        ));
    }
    public function createProduct(
        $name,
        $price,
        $old_price,
        $description,
        $preview,
        $color,
        $id_category,
        $count,
        $new,
        $bestSeller
    ) {
        $query = $this->db->prepare("INSERT INTO products (
            name,
            price,
            old_price,
            description,
            preview,
            color,
            id_category,
            count,
            new,
            bestseller
        )
       VALUES (
            :name,
            :price,
            :old_price,
            :description,
            :preview,
            :color,
            :id_category,
            :count,
            :new,
            :bestseller
       ) 
        
        ");
        $query->execute(array(
            "name" => $name,
            "price" => $price,
            "old_price" => $old_price,
            "description" => $description,
            "preview" => $preview,
            "color" => $color,
            "id_category" => $id_category,
            "count" => $count,
            "new" => $new,
            "bestseller" => $bestSeller
        ));
        return $this->db->lastInsertId();
    }

    public function createProductImage($id_product, $image)
    {
        $query = $this->db->prepare("INSERT INTO product_images(id_product, image) VALUES(:id_product, :image)");
        $query->execute(array(
            "id_product" => $id_product,
            "image" => $image
        ));
        return $this->db->lastInsertId();
    }

    public function deleteProduct($id_product)
    {
        $query = $this->db->prepare("DELETE FROM products WHERE id_product = $id_product");
        $query->execute(array(
            "id_product" => $id_product
        ));
    }

    public function searchProduct($search)
    {
        $query = $this->db->prepare("SELECT * FROM products WHERE products.name LIKE :search OR products.description LIKE :search");
        $query->execute(array(
            "search" => "%$search%"
        ));
        return $query->fetchAll();
    }


    public function editProduct(
        $id_product,
        $name,
        $price,
        $old_price,
        $description,
        $color,
        $id_category,
        $count,
        $new,
        $bestSeller
    ) {
        $query = $this->db->prepare("UPDATE products SET
        name = :name,
        price = :price,
        old_price = :old_price,
        description = :description,
        color = :color,
        id_category = :id_category,
        count = :count,
        new = :new,
        bestseller = :bestseller
        WHERE id_product = :id_product
        ");

        $query->execute(array(
            "id_product" => $id_product,
            "name" => $name,
            "price" => $price,
            "old_price" => $old_price,
            "description" => $description,
            "color" => $color,
            "id_category" => $id_category,
            "count" => $count,
            "new" => $new,
            "bestseller" => $bestSeller
        ));
    }
    public function editProductPreview(
        $id_product,
        $preview
    ) {
        $query = $this->db->prepare("UPDATE products SET
        preview = :preview
        WHERE id_product = :id_product
        ");

        $query->execute(array(
            "id_product" => $id_product,
            "preview" => $preview
        ));
    }


    public function editProductImage(
        $id_product_image,
        $image

    ) {
        $query = $this->db->prepare("UPDATE products SET
        id_product_image = :id_product_image,
        image=:image
        WHERE id_product = :id_product
        ");

        $query->execute(array(
            "id_product_image" => $id_product_image,
            "image" => $image
        ));
    }

    public function deleteProductImage($id_product_image)
    {
        $query = $this->db->prepare("DELETE FROM product_images WHERE id_product_image = :id_product_image");
        $query->execute(array(
            "id_product_image" => $id_product_image
        ));
    }
}
