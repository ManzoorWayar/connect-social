<?php

require_once '../bootstrap.php';
$objUsers = new Users;

if (isset($_GET['logout']) && $_GET['logout'] == true) {
    $objUsers->logout();
} else {
    return false;
}



