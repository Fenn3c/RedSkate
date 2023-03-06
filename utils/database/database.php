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
        $query = $this->db->prepare("SELECT * FROM products");
        $query->execute();
        return $query->fetchAll();
    }
    public function getProductById($id_product)
    {
        $query = $this->db->prepare("SELECT * FROM products WHERE id_product =:id+product");
        $query->execute(array(
            "id_product" => $id_product
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
}
