<?php
 require_once 'config/config.php';
 require_once 'helper/redirect.php';
 require_once 'helper/session_helper.php';

 spl_autoload_register(function($className) {
    require_once  'controller/'.$className .'.php';
 });

 require_once 'core/Database.php';
