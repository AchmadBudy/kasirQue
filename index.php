<?php
session_start();
$title = 'Kasir Que';
require_once 'data.php';
require_once 'template/__head.php';
require_once 'tambah_barang.php';
?>

<div class="content">
    <div class="judul">

        <h1>
            Kasir Que
        </h1>
        <a class="button" href="<?= $base_url; ?>keranjang.php">
            Keranjang
            <?php if (!isset($_SESSION['barang'])) : ?>
                <sup>0</sup>
            <?php else : ?>
                <sup><?= count($_SESSION['barang']); ?></sup>
            <?php endif; ?>
        </a>
    </div>

    <div class="barang">
        <?php foreach ($barangs as $barang) : ?>
            <div class="card">
                <div class="card-image">
                    <img src="assets/<?= $barang['img']; ?>" alt="random image">
                </div>
                <form action="" method="POST">
                    <div class="card-body">
                        <h2 class="title-barang">Pensil</h2>
                        <p>Rp.<?= number_format($barang['harga'], 0, ",", "."); ?></p>
                        <p>Stock <?= $barang['stock']; ?></p>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id" value="<?= $barang['id']; ?>">
                        <input type="hidden" name="nama" value="<?= $barang['nama']; ?>">
                        <input type="hidden" name="harga" value="<?= $barang['harga']; ?>">
                        <input type="number" name="qty" class="qty" min="1" max="<?= $barang['stock']; ?>" value="1">
                        <button class="addtocard" type="submit">Tambah</button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once 'template/__footer.php';
?>