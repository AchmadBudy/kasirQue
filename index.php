<?php
$title = 'Kasir Que';
require_once 'function.php';
$connection = new dataFunction();
$connection->isLoggedIn();
require_once 'template/__head.php';

if (isset($_POST['addtocart'])) {
    $connection->addCart($_POST);
}


if (isset($_POST['updateStock']) and $_SESSION['is_admin']) {
    $connection->updateStockProduct($_POST['id'], $_POST['qty']);
}


?>

<div class="content">
    <div class="judul">
        <h1>
            Kasir Que
        </h1>
        <a class="button" href="/keranjang.php">
            Keranjang
            <?php if (!isset($_SESSION['barang'])) : ?>
                <sup>0</sup>
            <?php else : ?>
                <sup><?= count($_SESSION['barang']); ?></sup>
            <?php endif; ?>
        </a>
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
    <div class="barang">

        <?php foreach ($connection->getAllProduct() as $barang) : ?>
            <div class="card">
                <div class="card-image">
                    <img src="assets/<?= $barang['image_product']; ?>" alt="random image">
                </div>
                <form action="" method="POST">
                    <div class="card-body">
                        <h2 class="title-barang"><?= $barang['product_name']; ?></h2>
                        <p>Rp.<?= number_format($barang['price'], 0, ",", "."); ?></p>
                        <p>Stock <?= $barang['stock']; ?></p>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id" value="<?= $barang['id']; ?>">
                        <input type="hidden" name="nama" value="<?= $barang['product_name']; ?>">
                        <input type="hidden" name="harga" value="<?= $barang['price']; ?>">
                        <input type="number" name="qty" class="qty" min="1" max="<?= $barang['stock']; ?>" value="1" required>
                        <button class="addtocard" type="submit" name="addtocart">Tambah</button>
                    </div>
                </form>
                <?php if ($_SESSION['is_admin']) : ?>
                    <div class="card-footer">
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= $barang['id']; ?>">
                            <input type="number" name="qty" class="qty" min="1" value="1" required>
                            <button class="button" type="submit" name="updateStock">Update Stock</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once 'template/__footer.php';
?>