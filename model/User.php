<?php
 class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get user data
    public function userData() {
      $sql = $this->db->query("SELECT *, username,
                                users.profile_img AS 'profileImg',
                                CONCAT(first_name, ' ', last_name) AS 'fullname'
                                FROM `users` 
                                WHERE id = :id");

      $userID = $_SESSION['user_id'];

      $this->db->bind('id', $userID);

      $row = $this->db->single();
      
      if ($row) {
          return $row;
      } else {
          return false;
      }
  }

    // Regsiter user
    public function register($data) {
        $this->db->query('INSERT INTO users (first_name, last_name, username, email, password, profile_img, coverImg) 
        VALUES(:firstName, :lastName, :userName, :email, :password, :profileImg, :coverImg)');
        // Bind values
        $this->db->bind(':firstName' , $data['firstName']);
        $this->db->bind(':lastName'  , $data['lastName']);
        $this->db->bind(':userName'  , $data['userName']);
        $this->db->bind(':email'     , $data['email']);
        $this->db->bind(':password'  , $data['password']);
        $this->db->bind(':profileImg', $data['profileImg']);
        $this->db->bind(':coverImg', $data['coverImg']);
  
        // Execute
        if($this->db->execute()) {
          return true;
        } else {
          return false;
        }
    }

    // Login User
    public function login($email, $password) {
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      $hashed_password = $row->password;

      if(password_verify($password, $hashed_password)) {
        return $row;
      } else {
        return false;
      }
    }

    // Find user by email
    public function findUserByEmail($email) {
      $this->db->query('SELECT * FROM users WHERE email = :email');
      // Bind value
      $this->db->bind(':email', $email);

      $this->db->single();

      // Check row
      if($this->db->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

    // User email verfication
    public function verificationEmail($email) {
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      if($this->db->rowCount() > 0) {
        return $row;
      } else {
        return false;
      }
    }

    // Fetch logged-in user data
    public function singleUser() {
      $this->db->query("SELECT CONCAT(users.first_name,' ', users.last_name) AS 'fullname', 
                        users.profile_img AS 'profileImg' 
                        FROM users WHERE id = :userID");

      // Bind value
      $userID = $_SESSION['user_id'];
      $this->db->bind('userID', $userID);

      $row = $this->db->single();

      // Check row
      if($this->db->rowCount() > 0) {
        return $row;
      } else {
        return false;
      }
    }

    // Update specific col of verifcation
    public function updateByVerified($data) {
      $this->db->query("UPDATE resetpassword SET verified = '1' 
                        WHERE email = :email AND verification = :verify");
      // Bind values
      $this->db->bind(':email',  $data['email']);
      $this->db->bind(':verify', $data['verify']);
      
      // Execute
      if($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // Insert OTP to resetPassword
    public function insertToResPass($data) {
      $this->db->query('INSERT INTO resetpassword (email, verification, verified)
                        VALUES(:email, :verifyCode, :verified)');
      // Bind values
      $this->db->bind(':email'    , $data['email']);
      $this->db->bind(':verifyCode', $data['verifyCode']);
      $this->db->bind(':verified'  , $data['verified']);
      
      // Execute
      if($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }
}