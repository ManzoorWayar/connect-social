<?php
 require_once '../model/RePost.php';
    class RePosts {
        public function __construct() {
          $this->rePostModel = new RePost;
        }

        public function rePosts($postId) {
            return $this->rePostModel->rePosts($postId);
        }

        public function rePostsCount($postId) {
            return $this->rePostModel->rePostsCount($postId);
        }

        public function isRePosted($postId) {
            $rePosted = $this->rePostModel->isRePosted($postId);

            if ($rePosted) {
                return $classSrc = "text-success";
            } else {
               return $classSrc = "text-info";
            }
        }

        public function checkRePosts($postID) {
            return $this->rePostModel->checkRePosts($postID);
        }

    }