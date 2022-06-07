<?php
require_once 'function.php';
$connection = new dataFunction();
$connection->isLoggedIn();
$title = 'Keranjang Kasir Que';
require_once 'template/__head.php';
if (!isset($_GET['hpid'])) {
    header('location: index.php');
    die();
}
$datas = $connection->getTransactionsById($_GET['hpid']);
if (count($datas) < 1) {
    header('location: index.php');
    die();
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
    </tr>
    <?php
    $i = 1;
    ?>
    <?php foreach ($datas as $data) : ?>
        <tr>
            <td class="text-center"><?= $i; ?></td>
            <td><?= $data['product_name']; ?></td>
            <td class="text-center"><?= number_format($data['qty'], 0, ",", "."); ?></td>
            <td class="text-center">Rp.<?= number_format($data['dprice'], 0, ",", "."); ?></td>
            <td class="text-center">Rp.<?= number_format($data['qty'] * $data['dprice'], 0, ",", "."); ?></td>
        </tr>
        <?php
        $i++;
        ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" class="abandoned"></td>
        <td>Net Total Rp.</td>
        <td class="text-center">Rp.<?= number_format($datas[0]['total_transaction'], 0, ",", "."); ?></td>
    </tr>
    <tr>
        <td colspan="3" class="abandoned"></td>
        <td>Payment</td>
        <td class="text-center"><?= $datas[0]['payment']; ?></td>
    </tr>
    <tr>
        <td colspan="3" class="abandoned"></td>
        <td>Waktu Transaksi</td>
        <td class="text-center"><?= $datas[0]['time_transaction']; ?></td>
    </tr>

</table>

<?php
require_once 'template/__footer.php';
?>