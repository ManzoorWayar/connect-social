<?php 
    require_once '../bootstrap.php';
    $pageTitle = "Edit-Profile | ". SITENAME;

     $objPosts = new Posts;
     $objProfile = new Profiles;
     $objLikes = new Likes;
     $objFriend = new Friends;
     $objRePosts = new RePosts;

     if (isset($_GET['id'])) {
        $friendID = $_GET['id'];
     } else {
        $friendID = $_SESSION['user_id'];
     }

     $posts = $objPosts->getSinglePost($friendID);
     $userProfile = $objProfile->userProfile($friendID);

    require_once 'inc/header.php';
 ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 mx-auto">
            <div class="card p-0 m-0">
                <div class="card-body text-center p-0 m-0">
                    <div id="cover">
                        <img src="<?=IMG?>coverUploadImgs/<?= $userProfile->coverImg;?>" alt="cover-image"
                            class=" p-0 m-0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- profile img -->
    <div class="profile">
        <img src="<?=IMG?>profileUploadImgs/<?= $userProfile->profileImg;?>" alt="profile-image">
    </div>
    <div class="row">
        <div class="col-md-9 mx-auto">
            <div class="row">
                <div class="col-md-4 my-3">
                    <div class="card">
                        <div class="card-body pb-2">
                            <p class="card-text">
                                <h6 class="card-title text-center pt-2 mb-0">
                                    <?= $userProfile->fullname;?></span>
                                    <i class="fa fa-check-circle pl-2 text-primary" aria-hidden="true"></i></h6>
                                <small class="profile-small">@<?=$userProfile->username?></small>
                                <p class="card-text text-center">
                                    <p class="border-bottom pb-2 text-center"><?= $userProfile->bio;?></p>
                                </p>
                                <button tpe="button"
                                    class="btn-block m-auto text-center <?=$objFriend->isFriend($friendID);?>"
                                    id="profile-btn" onclick="following(this, <?= $_GET['id'] ;?>)">
                                    <i class="fa fa-cog pr-2"></i>
                                    <span class="follow-text">
                                        <?=$objFriend->isFriend($friendID);?>
                                    </span>
                                </button>
                            </p>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header">
                            <span class="font-weight-bold text-primary">About:</span>
                            <span class="text-center pl-2"> <?= $userProfile->fullname;?></span>
                        </div>
                        <div class="card-body py-0">
                            <p class="card-text">
                                <p class="text-secondary">
                                    <i class="text-info pr-2 fa fa-graduation-cap"></i>
                                    Education: <?= $userProfile->education;?>
                                </p>
                                <p class="text-secondary">
                                    <i class="text-info pr-2 fa fa-map-marker"></i>
                                    live in: <?= $userProfile->live;?>
                                </p>
                                <p class="text-secondary">
                                    <i class="text-info pr-2 fa fa-calendar"></i>
                                    Born on: <?= $userProfile->born;?>
                                </p>
                                <p class="text-secondary">
                                    <i class="text-info pr-2 fa fa-briefcase"></i>
                                    Work: <?= $userProfile->work;?>
                                </p>
                                <p class=" text-secondary">
                                    <i class="text-info pr-2 fa fa-globe"></i>
                                    Age: <?= $userProfile->age;?>
                                </p>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Posts -->
                <div class="col-md-8 my-1">
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
                                    <img class="d-flex mr-2" src="<?=IMG?>profileUploadImgs/<?= $post->profileImg;?>"
                                        alt="profile-image">
                                    <div class="media-body">
                                        <h6 class="mt-0 font-weight-bold mb-0"><?= $post->fullname;?></h6>
                                        <small id="profile-post-date"><?= $objPosts->timeAgo($post->post_date)?></small>
                                    </div>
                                </div>
                            </h4>
                            <p type="text" id="user-post-card" name=""> <?= $post->post_txt;?></p>
                            <?php if(($post->postImg) >= 1 ):?>
                            <img class="card-img user-post-card-img" src="<?=IMG?>postUploadImgs/<?= $post->postImg;?>"
                                alt="">
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
                                            <button type="button" class="rePostButton rePostBtn"
                                                onclick="rePost(this, <?=$post->postID;?>)">
                                                <i class="fa fa-retweet <?=$objRePosts->isRePosted($post->postID);?> rePostButton"
                                                    aria-hidden="true"></i>
                                                <span
                                                    class="rePost-count text-info"><?= $objRePosts->rePostsCount($post->postID);?></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="like" id="<?=$post->postID;?>">
                                            <button type="button" class="likeButton likeBtn"
                                                onclick="likePost(this, <?=$post->postID;?>)">
                                                <i
                                                    class="fa <?= $objLikes->isLiked($post->postID) ;?> text-danger likeButton"></i>
                                                <span
                                                    class="like-count text-info"><?= $objLikes->likesCount($post->postID);?></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'inc/footer.php';?>