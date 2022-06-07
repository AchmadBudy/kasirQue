<?php

require_once 'function.php';
$connection = new dataFunction();
$connection->isGuest();

if (isset($_POST["login"])) {
    if ($connection->login($_POST)) {
        header('location: index.php');
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasir Que</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <style>
        input {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .card-body {
            padding: 0 10%;
        }

        .card {
            padding: 20px 0;
            box-shadow: 0 4px 6px rgb(1, 1, 1, 0.5);
        }
    </style>
</head>

<body>
    <div class="login">
        <div class="card">
            <div class="card-body">
                <h1>Login</h1>
                <?php if (isset($_SESSION['flash_message']['gagal'])) : ?>
                    <h4 style="color: red;"><?= $_SESSION['flash_message']['gagal']; ?></h4>
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <button type="submit" class="button" name="login">Login</button>
                </form>
                <!-- <div class="card" style="margin-top: 10px;  ">
                    <div class="card-body" style="padding: 0 0">
                        <p>Data Pengguna</p>
                        <hr>
                        <?php foreach ($user as $u) : ?>
                            <p>Username : <?= $u['username']; ?></p>
                            <p>Password : <?= $u['password']; ?></p>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</body>

</html>