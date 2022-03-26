<?php

if (isset($_POST['login'])) {
    if ($_POST['username'] == $user[0]['username']) {
        if ($_POST['username'] == $user[0]['username'] and $_POST['password'] == $user[0]['password']) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['login'] = true;
            $_SESSION['is_admin'] = true;
        } else {
            $errorbos = true;
        }
    } elseif ($_POST['username'] == $user[1]['username']) {
        if ($_POST['username'] == $user[1]['username'] and $_POST['password'] == $user[1]['password']) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['login'] = true;
            $_SESSION['is_admin'] = false;
        } else {
            $errorbos = true;
        }
    } else {
        $errorbos = true;
    }
}
