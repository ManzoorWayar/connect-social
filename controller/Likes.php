<?php
 require_once '../model/Like.php';
 
    class Likes {
        public function __construct() {
          $this->likeModel = new Like;
        }

        public function likes($postId) {
            return $this->likeModel->likes($postId);
        }

        public function likesCount($postId) {
            return $this->likeModel->likesCount($postId);
        }

        public function isLiked($postId) {
            $liked = $this->likeModel->isLiked($postId);

            if ($liked) {
                return $classSrc = "fa-heart";
            } else {
               return $classSrc = "fa-heart-o";
            }

        }
    }