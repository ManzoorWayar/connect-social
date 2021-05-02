<?php   
  $objUsers = new Users; 
  $objNotifications = new Notifications;

  $user  = $objUsers->singleUser();
  $notis = $objNotifications->getNotifications();
  
  ?>
<nav>
   <div class="top-nav-container">
      <a class="logo" href="home.php">
         <img src="<?= IMG ?>icons/favicon.ico" alt="site-logo">
         <h3 class="brand-name">Manzoor</h3>
      </a>
      <ul class="left-section">
         <li class="nav-item text-white header-item" id="noti-text-count">
            <i class="fa fa-bell fas-size pl-4 mr-1 notiBtn" id="noti_Button"></i>
            <!--SHOW NOTIFICATIONS COUNT.-->
            <span class="badge badge-pill badge-info p-1 noti-badge">
               <!-- <#?=$objNotifications->notificationsCount();?> -->
            </span>
            <!--THE NOTIFICAIONS DROPDOWN BOX.-->
            <div id="notifications">
               <h3 class="text-primary text-center border-bottom">Notifications</h3>
               <div id="notification-dropdwon">
                  <div class="card-body">
                     <h4 class="card-title notification-card-title ml-2">
                        <?php foreach($notis as $noti) :;?>
                        <?php if(($noti->noti_to) == $_SESSION['user_id']) :;?>
                        <a href="view-profile.php?id=<?= $noti->noti_from;?>" id="navbar-notifications-li">
                           <div class="media navbar-notification my-1 border-bottom">
                              <img class="d-flex mr-2" src="../assest/img/profileUploadImgs/<?= $noti->profileImg;?>"
                                 alt="profile-image">
                              <div class="media-body">
                                 <p class="mt-0 my-1 text-primary">
                                    <?= $noti->fullname;?> <?= $noti->msg;?> 
                                   </p>
                                 <!-- <small class="text-info"
                                    id="profile-post-date"><#?= $noti->notiDate ;?>
                                 </small> -->
                              </div>
                           </div>
                        </a>
                        <?php endif ;?>
                        <?php endforeach ;?>
                     </h4>
                  </div>
                  <div class="seeAll">
                     <a href="#">See All</a>
                  </div>
               </div>
         </li>
         <li class="header-item">
            <i class="fa fa-gear fas-size"></i>
         </li>
         <li class="header-item">
            <img src="<?=IMG?>profileUploadImgs/<?= $user->profileImg;?>" alt="profile-image">
            <span id="username">Hi, <?= $user->fullname;?></span>
         </li>
      </ul>
   </div>
   <div class="side-nav-container">
      <div class="side-navbar">
         <ul class="nav-header">
            <li class="header-item">
               <a href="home.php">
                  <i class="fa fa-home fa-2x"></i>
               </a>
            </li>
            <li class="header-item">
               <i class="fa fa-envelope fas-size"></i>
            </li>
            <li class="header-item">
               <a href="logout.php?logout=true">
                  <i class="fa fa-sign-out" aria-hidden="true"></i>
               </a>
            </li>
         </ul>
      </div>
   </div>
</nav>

<footer class="footer-nav">
   <ul>
      <li>
         <i class="fa fa-home" aria-hidden="true"></i>
      </li>
      <li>
         <i class="fa fa-envelope" aria-hidden="true"></i>
      </li>
      <li>
         <i class="fa fa-bell" aria-hidden="true"></i>
      </li>
   </ul>
</footer>