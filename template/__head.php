<?php
if (!isset($_SESSION['login'])) {
    header('location: login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar">
        <h1><a href="http://localhost/paw/uts">Kasir Que</a></h1>
        <div class="menu-nav">
            <?php if (isset($_SESSION['is_admin'])) : ?>
                <?php if ($_SESSION['is_admin']) : ?>
                    <p><a href="">Tambah</a></p>
                <?php endif; ?>
            <?php endif; ?>
            <div class="dropdown">
                <p>Hi, <?= $_SESSION['username']; ?></p>
                <div class="dropdown-content">
                    <a class="logout" href="<?= $base_url; ?>logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </nav>