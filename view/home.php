<?php 
    require_once '../bootstrap.php';
    $pageTitle = "Home | ". SITENAME;

    if (!$_SESSION['isLoggedIn']) {
      redirect('login');
    }
    
    require_once 'inc/header.php';

    $objUsers    = new Users;
    $objPosts    = new Posts;
    $objLikes    = new Likes;
    $objRePosts  = new RePosts;
    $objComments =  new Comments;
    $objFriends  = new Friends;

    $user     = $objUsers->userData();
    $posts    = $objPosts->getPosts();
    $friends  = $objFriends->allFriends();
    $comments = $objComments->getComments();
   
    if (isset($_POST['addPostBtn'])) {
      $objPosts->addPost();
    } 
?>

<div class="container mt-1">
  <div class="row">
    <div class="col-md-3 first-card">
      <div class="card text-center post-card-border sticky-top pt-3">
        <div class="card-body">
          <a href="profile.php" id="first-col-img">
            <img class="card-img" id="" src="<?=IMG?>/profileUploadImgs/<?=$user->profileImg?>" alt="">
            <span id="online-status"></span>
            <h6 class="card-title pt-2 mb-0">
              <?= $user->fullname;?>
              <i class="fa fa-check-circle pl-2 text-primary" aria-hidden="true"></i>
            </h6>
          </a>
          <small class="mb-3">@<?= $user->username;?></small>
          <a href="edit-profile.php" class="btn-block m-auto" id="side-btn">
            <i class="fa fa-cog pr-2"></i>Edit Profile
          </a>
          <ul class="list-group border-top" id="news-feed-side-ul">
            <li class="list-group-item border-0 news-feed-side-li mt-1">
              <span class="news-feed-side-detail">
                <i class="fa fa-picture-o pr-1 text-primary"></i>
                My Photos
              </span>
            </li>
            <li class="list-group-item border-0 news-feed-side-li">
              <span class="news-feed-side-detail">
                <i class="fa fa-language pr-1 text-primary"></i>
                Languages
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Middle / main section -->
    <div class="col-md-7">
      <div class="card post-card post-card-border">
        <form action="home.php" method="POST" id="posting-data" enctype="multipart/form-data">
          <div class="card-body pb-0">
            <?= flash('imgSize');?>
            <div class="card-title post-card">
              <div class="media">
                <img class="d-flex mr-2" src="<?=IMG?>profileUploadImgs/<?= $user->profileImg;?>" alt="profile-image">
                <div class="media-body">
                  <h6 class="my-0"><?= $user->fullname;?></h6>
                  <small class="mt-0 profile-username"><?=$user->username?></small>
                </div>
              </div>
            </div>
            <textarea class="post-textbox" id="postText" name="postText"
              placeholder="Share , post your ideas with our community"></textarea>
          </div>
          <div id="photo_preview_box">
            <i class="fa fa-camera file-bg-icon"></i>
            <input type="file" name="postImg" id="file-post-img">
          </div>
          <ul class="list-inline my-2 border-top">
            <li class="list-inline-item mt-2 mx-4">
              <button type="button" id="focusPost" class="py-1 px-2">
                <i class="fa fa-pencil text-info pr-2"></i>Write...</button>
            </li>
            <li class="list-inline-item">
              <button type="button" class="py-1 px-2" id="togglePhoto">
                <i class="fa fa-photo text-success pr-2"></i>Photo</button>
            </li>
            <li class="list-inline-item last-li-card float-right mr-3">
              <span id="word-num">200<span>
                  <input type="submit" name="addPostBtn" id="addBtn" disabled role="button" value="POST">
            </li>
          </ul>
        </form>
      </div>
      <?php foreach($posts as $post) :?>
      <div class="card post-card-border my-2">
        <div class="card-body pb-2">
          <div class="re-post">
            <?php if(!empty($rePosts=$objRePosts->checkRePosts($post->postID)) == $_SESSION['user_id']):?>
            <i class="fa fa-retweet text-info"></i>
            <?php foreach($rePosts as $rePost) :?>
            @<?=$rePost->username?>
            <?php endforeach ?>
            <?php endif ?>
          </div>
          <h4 class="card-title">
            <div class="media">
              <img class="d-flex mr-2" src="<?=IMG?>profileUploadImgs/<?= $post->profileImg;?>" alt="profile-image">
              <div class="media-body">
                <h6 class="mt-0 font-weight-bold mb-0"><?= $post->fullname;?></h6>
                <small id="profile-post-date"><?= $objPosts->timeAgo($post->post_date)?></small>
              </div>
            </div>
          </h4>
          <p type="text" id="user-post-card" name=""> <?= $post->post_txt;?></p>
          <?php if(($post->postImg) >= 1 ):?>
          <img class="card-img user-post-card-img" src="<?=IMG?>postUploadImgs/<?= $post->postImg;?>" alt="">
          <?php else :?>
          <img class="d-none" alt="no image">
          <?php endif ?>
          <div class="comments-details">
            <div class="d-flex flex-row justify-content-center">
              <div class="p-4">
                <div class="comment" id="<?=$post->postID;?>">
                  <button type="button" class="comBtnIcon">
                    <i class="fa fa-commenting-o text-secondary"></i>
                    <span class="comment-count text-info"></span>
                  </button>
                </div>
              </div>
              <div class="p-4">
                <div class="rePost" id="<?=$post->postID;?>">
                  <button type="button" class="rePostButton rePostBtn" onclick="rePost(this, <?=$post->postID;?>)">
                    <i class="fa fa-retweet <?=$objRePosts->isRePosted($post->postID);?> rePostButton"
                      aria-hidden="true"></i>
                    <span class="rePost-count text-info"><?= $objRePosts->rePostsCount($post->postID);?></span>
                  </button>
                </div>
              </div>
              <div class="p-4">
                <div class="like" id="<?=$post->postID;?>">
                  <button type="button" class="likeButton likeBtn" onclick="likePost(this, <?=$post->postID;?>)">
                    <i class="fa <?= $objLikes->isLiked($post->postID) ;?> text-danger likeButton"></i>
                    <span class="like-count text-info"><?= $objLikes->likesCount($post->postID);?></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- <i class="fa fa-comments comment-sh" aria-hidden="true"></i> -->
          <div class="user-comment">
            <?php
            foreach($comments as $comment) {
              if ($comment->post_id == $post->postID) {
              echo '
                  <h4 class="card-title">
                       <div class="media">
                           <img class="d-flex mr-2" src="'.IMG .'profileUploadImgs/'.$comment->profileImg.'">
                           <div class="media-body">
                               <h6 class="mt-0 font-weight-bold mb-0">'.$comment->fullname.'</h6>
                               <p class="comment-box">'.$comment->comment_txt.'</p>
                               <small id="profile-comment-date" class="pl-2">'. $objPosts->timeAgo($comment->commentDate).'</small>
                           </div>
                       </div>
                   </h4>';
              }
            }
           ?>
            <form method="post" autocomplete="off" class="py-2" id="comment-form">
              <div class="general-comment-box-width general-comment-box" id="<?=$post->postID;?>">
                <textarea class="general-comment-feild" name="commentTxt" id="comment-<?=$post->postID;?>"
                  placeholder="Write a comment ..."></textarea>
                <button type="button" class="commentBtn">
                  <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach?>
    </div>

    <!-- 3rd part -->
    <div class="col-md-2 mt-1">
      <aside class="sticky-top pt-2">
        <div class="list-group list-group-3">
          <p href="#" class="text-center list-group-item list-group-item-action active">
            Friends
          </p>
          <?php foreach($friends as $friend) :;?>
          <?php if ($friend->reciver !== $_SESSION['user_id']) :;?>
          <a href="view-profile.php?id=<?=$friend->reciver;?>"
            class="list-group-item list-group-item-action friend-card-list mt-1">
            <img src="<?=IMG?>profileUploadImgs/<?= $friend->profileImg;?>" alt="profile-image" class="ml-2">
            <span class="pl-1"><?= $friend->fullname ;?></span>
          </a>
          <?php endif ;?>
          <?php endforeach ;?>
        </div>
      </aside>
    </div>
  </div>
</div>

<!-- Comment Err Modal -->
<div class="modal fade" id="comment-err-show" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">Warning</h5>
      </div>
      <div class="modal-body">
        <h6 class="text-danger text-center">Please write your comment to comment...</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- comment add Modal -->
<div class="modal fade" id="comment-success-show" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success text-center">Success</h5>
      </div>
      <div class="modal-body">
        <h6 class="text-success text-center">Your Comment was added successfuly</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<?php require_once 'inc/footer.php' ;?>