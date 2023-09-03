<?php

include 'connect.php';

session_start();
session_unset();
session_destroy();
// $_SERVER['PHP_SELF']
header('location:../admin/admin_login.php');

?>