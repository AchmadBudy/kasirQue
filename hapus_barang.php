<?php

if (isset($_POST['id'])) {
    unset($_SESSION['barang'][$_POST['id']]);
}
