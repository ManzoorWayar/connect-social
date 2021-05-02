<?php
    require_once '../model/Comment.php';
 class Comments {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment;
    }

    public function addComments($postID, $commentTxt) {
        return $this->commentModel->addComments($postID, $commentTxt);
    }

    public function getComments() {
        return $this->commentModel->getComments();
    }

 }
 