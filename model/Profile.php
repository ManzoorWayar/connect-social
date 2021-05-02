<?php
  class Profile {
      private $db;

      public function __construct() {
          $this->db = new Database;
      }

    public function userProfile($userID) {
        $sql = $this->db->query("SELECT profile.*, users.first_name AS 'fisrtName',
                                users.last_name AS 'lastName', users.email AS 'email',
                                CONCAT(users.first_name, ' ', users.last_name) AS 'fullname',
                                users.username, users.profile_img AS 'profileImg',
                                users.cover_img AS 'coverImg' FROM profile 
                                RIGHT JOIN users ON profile.user_id = users.id 
                                WHERE users.id = :id");

      $this->db->bind('id', $userID);

      $row = $this->db->single();

      if($row) {
        return $row;
        } else {
        return false;
      }
    }

   public function updateProfile($colDB, $newImg) {
       $sql = $this->db->query("UPDATE users SET $colDB = :image WHERE id = :id");

        $userID = $_SESSION['user_id'];

        $this->db->bind('id', $userID);
        $this->db->bind('image', $newImg);
        
        if($this->db->execute()) {
          return true;
          } else {
          return false;
          }
        }

        // Edit Profile
        public function updateUserProfile($data) {

          if ($this->isExistProfile()) {
          $sql = $this->db->query("UPDATE `profile` INNER JOIN users 
                                    ON profile.user_id = users.id SET
                                    users.first_name = :firstName,
                                    users.last_name = :lastName,
                                    users.email = :email,
                                    education = :education,
                                    live = :country,
                                    work = :job,
                                    born = :birthday,
                                    age = :age,
                                    bio = :bio
                                    WHERE profile.user_id = :id");
          
          $userID = $_SESSION['user_id'];
          
          $this->db->bind('id', $userID);
          $this->db->bind('firstName', $data['firstName']);
          $this->db->bind('lastName', $data['lastName']);
          $this->db->bind('email', $data['email']);
          $this->db->bind('education', $data['education']);
          $this->db->bind('country', $data['country']);
          $this->db->bind('job', $data['job']);
          $this->db->bind('birthday', $data['birthday']);
          $this->db->bind('age', $data['age']);
          $this->db->bind('bio', $data['bio']);
        
          if ($this->db->execute()) {
              return true;
              } else {
              return false;
            }

          //Insert Data 
          } else {

            $this->db->query('INSERT INTO profile (user_id, education, live, work, born, age, bio) 
            VALUES(:userID, :education, :country, :job, :birthday, :age, :bio)');

            $userID = $_SESSION['user_id'];

            // Bind values
            $this->db->bind(':userID', $userID);
            $this->db->bind(':education' , $data['education']);
            $this->db->bind(':country'  , $data['country']);
            $this->db->bind(':job'  , $data['job']);
            $this->db->bind(':birthday'     , $data['birthday']);
            $this->db->bind(':age'  , $data['age']);
            $this->db->bind(':bio', $data['bio']);
      
            // Execute
            if ($this->db->execute()) {
              return true;
            } else {
              return false;
            }
          }

        }

        private function isExistProfile() {
          $this->db->query("SELECT * FROM profile WHERE user_id = :userID");

          $userID = $_SESSION['user_id'];  
          $this->db->bind('userID', $userID);
 
          $row = $this->db->single();
 
          if ($this->db->rowCount() > 0) {
              return true;
          } else {
              return false;
          }
        }
  }
      
  