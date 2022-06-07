<?php
$title = 'Kasir Que';
require_once 'function.php';
$connection = new dataFunction();
$connection->isLoggedIn();
require_once 'template/__head.php';
if (!isset($_SESSION['is_admin'])) {
    header('location: login.php');
    die;
}
if (isset($_POST['tambah'])) {
    $connection->addProduct($_POST, $_FILES['image_product']);
}

?>

<div class="content">
    <div class="judul">
        <h1>
            Tambah Barang
        </h1>
    </div>

    <?php if (isset($_SESSION['flash_message']['gagal'])) : ?>
        <div class="notif-failed">
            <h4><?= $_SESSION['flash_message']['gagal']; ?></h4>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['flash_message']['sukses'])) : ?>
        <div class="notif-success">
            <h4><?= $_SESSION['flash_message']['sukses']; ?></h4>
        </div>
    <?php endif; ?>


    <div class="card">
        <div class="card-body" style="padding:5% 20% ;">
            <form action="" method="post" enctype="multipart/form-data">
                <label for="image_product">Gambar Produk</label>
                <input type="file" name="image_product" id="image_product" required>
                <label for="product_name">Nama Produk</label>
                <input type="text" name="product_name" id="product_name" required>
                <label for="price">Harga Rp:</label>
                <input type="number" name="price" id="price" min="0" required>
                <label for="stock">Stock : </label>
                <input type="number" name="stock" id="stock" min="0" required>

                <button class="button" name="tambah" type="submit">Tambah Produk</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'template/__footer.php';
?>