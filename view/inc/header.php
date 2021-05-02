<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assest/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kulim+Park:wght@200;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assest/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assest/css/style.css" />
    <title><?= $pageTitle?></title>
</head>
<body>
<?php  ($_SERVER['SCRIPT_NAME'] !== '/so/view/login.php'  && 
       $_SERVER['SCRIPT_NAME'] !== '/so/view/signup.php' &&
       $_SERVER['SCRIPT_NAME'] !== '/so/view/ressPass.php') 
        ? require_once 'navbar.php' : ''; ?>