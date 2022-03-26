<?php
session_start();
$title = 'Keranjang Kasir Que';
require_once 'data.php';
require_once 'hapus_barang.php';
require_once 'template/__head.php';
?>

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
    $total = 0;
    ?>
    <?php if (isset($_SESSION['barang'])) : ?>
        <?php foreach ($_SESSION['barang'] as $data) : ?>
            <tr>
                <td class="text-center"><?= $i; ?></td>
                <td><?= $data['nama']; ?></td>
                <td class="text-center"><?= number_format($data['qty'], 0, ",", "."); ?></td>
                <td class="text-center">Rp.<?= number_format($data['harga'], 0, ",", "."); ?></td>
                <?php $total += $data['qty'] * $data['harga'] ?>
                <td class="text-center">Rp.<?= number_format($data['qty'] * $data['harga'], 0, ",", "."); ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                        <button type="submit" class="hapus">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php
            $i++;
            $total += $data['harga'];
            ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <tr>
        <td colspan="3" rowspan="4" class="abandoned"></td>
        <td>Gross Total Rp.</td>
        <td class="text-center">Rp.<?= number_format($total, 0, ",", "."); ?></td>
    </tr>
    <tr>
        <td>Diskon % </td>
        <td class="text-center"><?= $diskon * 100; ?>%</td>
    </tr>
    <tr>
        <td>PPN % </td>
        <td class="text-center"><?= $ppn * 100; ?>%</td>
    </tr>
    <tr>
        <td>Net Total Rp.</td>
        <td class="text-center">Rp.<?= number_format(($total - ($total * $diskon)) + (($total - ($total * $diskon)) * $ppn), 0, ",", "."); ?></td>
    </tr>
</table>

<?php
require_once 'template/__footer.php';
?>