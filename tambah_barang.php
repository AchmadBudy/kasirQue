<?php

if (isset($_POST['id'])) {
    $_SESSION['barang'][$_POST['id']]['id'] = $_POST['id'];
    $_SESSION['barang'][$_POST['id']]['nama'] = $_POST['nama'];
    $_SESSION['barang'][$_POST['id']]['harga'] = $_POST['harga'];
    if (isset($_SESSION['barang'][$_POST['id']]['qty'])) {
        # code...
        $_SESSION['barang'][$_POST['id']]['qty'] += $_POST['qty'];
    } else {
        # code...
        $_SESSION['barang'][$_POST['id']]['qty'] = $_POST['qty'];
    }
}
