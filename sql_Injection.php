<?php
$db_settings = parse_ini_file("./utils/database/database.config.ini");
$dsn = "mysql:host=" . $db_settings['HOST'] . ";dbname=" . $db_settings['DB'] . ";charset=" . $db_settings['CHARSET'] . ";";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => true,
];
$db = new PDO($dsn, $db_settings['USER'], $db_settings['PASSWORD'], $options);


// const test = $_GET['test'] ?? 0;



if(isset($_GET['test'])){
    $test = $_GET['test'];
    $query = $db->prepare("SELECT * from products WHERE id_product = :test");
    $query->execute(array(
        "test" => $test
    ));
    var_dump($query->fetchAll());
}
