<?php
class ButtonProvider {
    public static function createTweetButton($text,$imageSrc,$class,$countClassName,$PostID,$postedBy,$userID) {
        return '
        <button class="'.$class.'" data-post="'.$PostID.'" data-postedBy="'.$PostID.'" data-user="'.$userID.'"> 
       '.$imageSrc.'
        <span class="'.$countClassName.'">'.$text.'</span>
        </button>
        ';
    }

    public static function createLikeButton($text,$imageSrc,$class,$action,$PostID,$postedBy,$userID) {
        return '
        <button data-post="'.$PostID.'" onclick="'.$action.'" data-postedBy="'.$PostID.'" data-user="'.$userID.'"> 
        <i class="fa fa-'.$class.'" aria-hidden="true"></i>
        <span class="likesCounter">'.$text.'</span>
        </button>
        ';
    }
}