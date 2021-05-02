<?php
    require_once '../bootstrap.php';
    $objPosts = new Posts();

    if (POST_REQUEST()) {
        if (isset($_POST['fetchPosts']) && !empty($_POST['fetchPosts'])) {

            $limit = (int)trim($_POST['fetchPosts']);
         
            // echo $limit;
             $objPosts->getPosts($limit);
        }
    }