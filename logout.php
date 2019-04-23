<?php
if(isset($_COOKIE['user']))
{
    setcookie('user', '', time() - 3600, '/');
    unset($_COOKIE['user']);
}
session_start();
session_unset();
session_destroy();
header('location:./intro.php');