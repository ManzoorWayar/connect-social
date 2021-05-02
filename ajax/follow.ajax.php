<?php
    require_once '../bootstrap.php';
    $objFriends = new Friends;

    if (isset($_POST['reciverId'])) {
        $reciverId = $_POST['reciverId'];
         
        echo $objFriends->followFriend($reciverId);
    }