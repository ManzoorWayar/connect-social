<?php
    require_once '../bootstrap.php';
    $objRePosts = new RePosts;

    if (isset($_POST['postId'])) {
      $postId = $_POST['postId'];
      echo $objRePosts->rePosts($postId);
    }

//    else if (isset($_POST['action']) && $_POST['action'] === 'rePosting' && !empty($_POST['postId'])) {
//         $postId = $_POST['postId'];
//         echo $objRePosts->checkRePosts($postId);
//       }
  

    