<?php
    require_once '../bootstrap.php';
    $objLikes = new Likes;

    if (isset($_POST['postId'])) {
      $postId = $_POST['postId'];
      echo $objLikes->likes($postId);
    }