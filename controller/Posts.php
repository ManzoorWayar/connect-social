<?php
    require_once '../model/Post.php';
class Posts {
    private $postModel;
    private $imgSize = 300000000;

    public function __construct() {
        $this->postModel = new Post();
        $this->userModel = new Users;
        $this->PostControl = new PostControls;
    }

    // Fetch user's data 
    public function getPosts() {
        return $this->postModel->getPosts();
    }

    // Add post
    public function addPost() {
        if (POST_REQUEST()) {

            if (empty($_POST['postTxt']) !== '' && !empty($_FILES['postImg'])) {

                $data = [
                    'postTxt' => $this->userModel->formSanitaizer($_POST['postText']),
                    'postImg' => $this->setPostImg()
                ];
            
            } else if (!empty($_POST['postTxt']) && empty($_FILES['postImg'])) {

                $data = [
                    'postTxt' => $this->userModel->formSanitaizer($_POST['postText']),
                    'postImg' => NULL
                ];
            } 

            $data['post_date'] = date('Y-m-d H:i:s');

            if ($this->postModel->addPost($data)) {
                redirect("home.php") ;
           } else {
               die('something went wrong');
           }
        }
    }

    // new change
    public function getSinglePost($userId) {
        return $this->postModel->getSinglePost($userId);
    }

    // Upload Post image: home page
    private function setPostImg() {

        // Files needed features
        $fileName = $_FILES['postImg']['name'];
        $tmp_name =  $_FILES['postImg']['tmp_name'];
        $fileSize = $_FILES['postImg']['size'];
        $fileError = $_FILES['postImg']['error'];
        $fileType = $_FILES['postImg']['type'];

        // Seperating & detecting the Extentions
        $fileExt = explode('.', $fileName);
        // Get the last piece of an array
        $fileActualExt = strtolower(end($fileExt));
        // Extenstions which can be upload
        $allowedExt = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowedExt)) {
            if ($fileError == 0 && $fileSize < $this->imgSize) {
               // Create new name 
               $fileNewName = uniqid('', true) . "." . $fileActualExt;
               $fileDestination = '../assest/img/postUploadImgs/' . $fileNewName;
               $moved = move_uploaded_file($tmp_name, $fileDestination);

               // If successfully image was moved
              if ($moved) {
                  return $fileNewName;
              } else {
                  return false;
              }
           
            } else {
                // Making an alert pop up 
                flash('imgSize', 'Image size should not be more than 30mb');
                return false;
            }
        }
    }

    // Time ago 
    public function timeAgo($datetime){
        $time = strtotime($datetime);
        $current = time();
        $seconds = $current-$time;
        $minutes = round($seconds/60);
        $hours = round($seconds/3600);
        $months = round($seconds/2600640);

        if ($seconds <= 60) {
            if($seconds == 0) {
                return 'Just now';
            } else {
                return ''.$seconds.'s';
            }

        } else if ($minutes <= 60) {
            return ''.$minutes.'m ago';
        } else if ($hours <= 24) {
            return ''.$hours.'h ago';
        } else if ($months <= 24) {
            return ''.date('M j', $time);
        } else {
            return ''.date('j M Y', $time);
        }
    }
    
}