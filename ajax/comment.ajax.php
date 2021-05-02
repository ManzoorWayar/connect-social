<?php
    require_once '../bootstrap.php';
    $objComments = new Comments;

    if (isset($_POST['postId']) && isset($_POST['commentTxt'])) {

      $postId = $_POST['postId'];
      $commentTxt = $_POST['commentTxt'];

      $objComments->addComments($postId, $commentTxt);

    }