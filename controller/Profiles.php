<?php
   require_once '../model/Profile.php';

class Profiles {
    private $profileModel;
    private $imgSize = 30000000;

    public function __construct() {
        $this->profileModel = new Profile;
    }

    public function userProfile($userId) {
        return $this->profileModel->userProfile($userId);
    }

    public function setCoverImg() {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['coverSaveBtn'])) {

            $coverImg = $this->changeCoverImg();

            if ($this->profileModel->updateProfile('cover_img', $coverImg)) {
                redirect('../view/profile.php');
            } else {
                die('something went wrong');
            }

        }
    }

    public function setProfileImg() {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['profileSaveBtn'])) {

            $profileImg = $this->changeProfileImg();

            if ($this->profileModel->updateProfile('profile_img', $profileImg)) {
                redirect('../view/profile.php');
            } else {
                die('something went wrong');
            }

        }
    }

     // Upload Cover image
     private function changeCoverImg() {

        // Files needed features
        $fileName = $_FILES['cover']['name'];
        $tmp_name =  $_FILES['cover']['tmp_name'];
        $fileSize = $_FILES['cover']['size'];
        $fileError = $_FILES['cover']['error'];
        $fileType = $_FILES['cover']['type'];

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
               $fileDestination = '../assest/img/coverUploadImgs/' . $fileNewName;
               $moved = move_uploaded_file($tmp_name, $fileDestination);

               // If successfully image was moved
              if ($moved) {
                  return $fileNewName;
              } else {
                  return false;
              }
           
            } else {
                // Making an alert pop up 
                return false;
            }
        }
   }


    // Upload Profile image
    private function changeProfileImg() {

        // Files needed features
        $fileName = $_FILES['profile']['name'];
        $tmp_name =  $_FILES['profile']['tmp_name'];
        $fileSize = $_FILES['profile']['size'];
        $fileError = $_FILES['profile']['error'];
        $fileType = $_FILES['profile']['type'];

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
               $fileDestination = '../assest/img/profileUploadImgs/' . $fileNewName;
               $moved = move_uploaded_file($tmp_name, $fileDestination);

               // If successfully image was moved
              if ($moved) {
                  return $fileNewName;
              } else {
                  return false;
              }
           
            } else {
                // Making an alert pop up 
                return false;
            }
        }
   }

    // Edit Profile 
    public function editProfle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateBtn'])) {

            $data = [
                'firstName' => htmlspecialchars($_POST['firstname']),
                'lastName' => htmlspecialchars($_POST['lastname']),
                'email' => htmlspecialchars($_POST['email']),
                'education' => htmlspecialchars($_POST['education']),
                'country' => htmlspecialchars($_POST['country']),
                'job' => htmlspecialchars($_POST['job']),
                'birthday' => htmlspecialchars($_POST['birthday']),
                'age' => htmlspecialchars($_POST['age']),
                'bio' => htmlspecialchars($_POST['bio'])
            ];
         
            if (
            !empty($data['firstName']) && !empty($data['lastName']) && !empty($data['email']) &&
            !empty($data['education']) && !empty($data['country']) && !empty($data['job']) &&
            !empty($data['birthday'])  && !empty($data['age']) && !empty($data['bio'])) {

                if ($this->profileModel->updateUserProfile($data)) {
                    redirect('../view/profile.php');
                } else {
                    die("something went wrong with DB!");
                }

            } else {
                die("please fill in all feilds");
            }
        }
    }

      
   }