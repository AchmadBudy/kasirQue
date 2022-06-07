<?php
$title = 'Kasir Que';
require_once 'function.php';
$connection = new dataFunction();
$connection->isLoggedIn();
require_once 'template/__head.php';

if (isset($_POST['regis'])) {
    $connection->register($_POST);
}


?>
<div class="content" style="padding-top: 20px;">
    <div class="card">
        <div class="card-body">
            <h1>Tambah User</h1>
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
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <button type="submit" class="button" name="regis">Registrasi</button>
            </form>
        </div>
    </div>
</div>
<?php
require_once 'template/__footer.php';
?>