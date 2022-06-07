<?php
require_once 'function.php';
$connection = new dataFunction();
$connection->isLoggedIn();
$title = 'Keranjang Kasir Que';
require_once 'template/__head.php';
if (isset($_POST['hapus']) && $_SESSION['is_admin']) {
    $connection->delTrasactions($_POST['id']);
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
<?php if ($_SESSION['is_admin']) : ?>
    <table id="nota">
        <tr>
            <th>No.</th>
            <th>Username</th>
            <th>Payment</th>
            <th>Total Traksaksi (Rp.)</th>
            <th>Waktu</th>
            <th>Action</th>
        </tr>
        <?php
        $i = 1;
        ?>
        <?php foreach ($connection->getAllTransactions() as $data) : ?>
            <tr>
                <td class="text-center"><?= $i; ?></td>
                <td><?= $data['username']; ?></td>
                <td class="text-center"><?= $data['payment']; ?></td>
                <td class="text-center">Rp.<?= number_format($data['total_transaction'], 0, ",", "."); ?></td>
                <td class="text-center"><?= $data['time_transaction']; ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?= $data['tid']; ?>">
                        <button type="submit" class="hapus" name="hapus">Hapus</button>
                    </form>
                    <a href="/detail_payment.php?hpid=<?= $data['tid']; ?>" class="button">Lihat Details</a>
                </td>
            </tr>
            <?php
            $i++;
            ?>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <table id="nota">
        <tr>
            <th>No.</th>
            <th>Payment</th>
            <th>Total Traksaksi (Rp.)</th>
            <th>Waktu</th>
            <th>Action</th>
        </tr>
        <?php
        $i = 1;
        ?>
        <?php foreach ($connection->getUserTransactions($_SESSION['user_id']) as $data) : ?>
            <tr>
                <td class="text-center"><?= $i; ?></td>
                <td class="text-center"><?= $data['payment']; ?></td>
                <td class="text-center">Rp.<?= number_format($data['total_transaction'], 0, ",", "."); ?></td>
                <td class="text-center"><?= $data['time_transaction']; ?></td>
                <td>
                    <a href="/detail_payment.php?hpid=<?= $data['tid']; ?>" class="button">Lihat Details</a>
                </td>
            </tr>
            <?php
            $i++;
            ?>
        <?php endforeach; ?>

    </table>
<?php endif; ?>

<?php
require_once 'template/__footer.php';
?>