<?php

require_once 'function.php';

$connection = new dataFunction();

// var_dump($connection->register(['username' => 'admin', 'password' => 'admin123']));

// var_dump($connection->login(['username' => 'admin', 'password' => 'admin123']));

// var_dump($connection->addProduct(['image_product' => 'gambar.jpg', 'product_name' => 'gambar 4dffffffff', 'price' => 15000, 'stock' => 10]));
// $barang = $connection->getAllProduct();
// var_dump($barang[0]);
// var_dump($connection->addTransactions('cash'));

// var_dump($connection->getAllTransactions());

var_dump($connection->getTransactionsById(4));
echo "<br>";
// var_dump($connection->getUserTransactions($_SESSION['user_id']));
// var_dump(empty($connection->getProductById(2)));
// var_dump($connection->editProductById(['image_product' => 'gambarsss.jpg', 'product_name' => 'gambar 5d', 'price' => 15000, 'stock' => 10, 'id' => 2]));

// var_dump($connection->deleteProductById(3));
// echo "<br>";

// var_dump($connection->getAllProduct());
// $connection->logout();

if (isset($_SESSION['flash_message'])) {
    var_dump($_SESSION['flash_message']);
}
