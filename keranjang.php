<?php
require_once 'function.php';
$connection = new dataFunction();
$connection->isLoggedIn();
$title = 'Keranjang Kasir Que';
require_once 'template/__head.php';
if (isset($_POST['hapus'])) {
    $connection->delCart($_POST['id']);
}

if (isset($_POST['pay'])) {
    $connection->addTransactions($_POST['payment']);
}
?>
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
<table id="nota">
    <tr>
        <th>No.</th>
        <th>Nama Barang</th>
        <th>Sebanyak</th>
        <th>Harga (Rp.)</th>
        <th>Jumlah (Rp.)</th>
        <th>Action</th>
    </tr>
    <?php
    $i = 1;
    ?>
    <?php if (isset($_SESSION['barang'])) : ?>
        <?php foreach ($_SESSION['barang'] as $data) : ?>
            <tr>
                <td class="text-center"><?= $i; ?></td>
                <td><?= $data['nama']; ?></td>
                <td class="text-center"><?= number_format($data['qty'], 0, ",", "."); ?></td>
                <td class="text-center">Rp.<?= number_format($data['harga'], 0, ",", "."); ?></td>
                <td class="text-center">Rp.<?= number_format($data['qty'] * $data['harga'], 0, ",", "."); ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                        <button type="submit" class="hapus" name="hapus">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php
            $i++;
            ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <tr>
        <td colspan="3" class="abandoned"></td>
        <td>Net Total Rp.</td>
        <td class="text-center">Rp.<?= number_format($_SESSION['total_harga'], 0, ",", "."); ?></td>
    </tr>
    <?php if (isset($_SESSION['barang'])) : ?>
        <tr>
            <td colspan="3" class="abandoned"></td>
            <td>Select Payment</td>
            <form action="" method="POST">
                <td class="text-center">
                    <select id="payment" name="payment">
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>
                    </select>
                </td>
                <td>
                    <button class="button" type="submit" name="pay">Bayar</button>
                </td>
            </form>
        </tr>
    <?php endif; ?>
</table>

<?php
require_once 'template/__footer.php';
?>