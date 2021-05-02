<?php

class PostControls {

    public function createControls($PostID, $postedBy) {

        $replyBtn = $this->createReplyBtn($PostID, $postedBy);
        $retweetBtn = $this->createRetweetBtn($PostID, $postedBy);
        $likeBtn = $this->createLikeBtn($PostID, $postedBy);

        return "<div class='comments-details'>
                  <div class='d-flex flex-row justify-content-center'>
                     $replyBtn
                     $retweetBtn
                     $likeBtn
                  </div>
                </div>";
    }

    private function createReplyBtn($PostID, $postedBy) {
        $text="";
        $class="replyModal";
        $countClassName="replyCount";
        return '<div class="p-4"> 
        '.ButtonProvider::createTweetButton($text,$imageSrc,$class,$countClassName,$PostID,$postedBy).'
                </div>';
    }

    private function createRetweetBtn($PostID, $postedBy) {
        $text="";
        $class="retweet";
        $countClassName="retweetsCount";
        return '<div class="p-4"> 
        '.ButtonProvider::createTweetButton($text,$imageSrc,$class,$countClassName,$PostID,$postedBy).'
                </div>';
    }

    private function createLikeBtn($PostID, $postedBy) {
        $text="";
        $class="like-btn";
        $imageSrc='<i class="fa fa-heart-o"></i>';
        $action="likePost(this,$postID,$postedBy)";
        return '<div class="p-4"> 
        '.ButtonProvider::createLikeButton($text,$imageSrc,$class,$action,$PostID,$postedBy).'
                </div>';
    }
}