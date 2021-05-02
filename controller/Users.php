<?php
    require_once '../model/User.php';
class Users {
    private $userModel;
    private $verifyModel;
    private $errArr;
    private static $formData;

    public function __construct() {
      $this->errArr = array();
      $this->userModel = new User();
      $this->verifyModel = new Verifyz();
    }

    // Get user's data
    public function userData() {
      return $this->userModel->userData();
  }

    // Sanitize every input
    public function formSanitaizer($inputField) {
      return htmlspecialchars(strip_tags(trim($inputField)));
    }

    // Remove double space between Words
    private function removeSpaces($inputField) {
      return preg_replace('/\s+/', ' ',$inputField);
    }

    // Rigester the user's from
    public function register() {
      if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        self::$formData = [
            'firstName' => $this->formSanitaizer($this->removeSpaces($_POST['firstName'])),
            'lastName' => $this->formSanitaizer($this->removeSpaces($_POST['lastName'])),
            'email' => $this->formSanitaizer($_POST['email']),
            'password' => $this->formSanitaizer($_POST['password']),
            'confirm_password' => $this->formSanitaizer($_POST['confirm_password'])
          ];

          $this->validateFirstName(self::$formData['firstName']);
          $this->validatelastName(self::$formData['lastName']);
          $userName = $this->genereatUserName(self::$formData['firstName'], self::$formData['lastName']);
          $this->validateEmail(self::$formData['email']);
          $this->validatePassword(self::$formData['password'], self::$formData['confirm_password']);
          $this->validateConfirmPassword(self::$formData['password'], self::$formData['confirm_password']);
          $this->verificationEmail();

          // Rigester the user 
          if ($this->isErrorsEmpty()) {

            // Create a username => add to []
            self::$formData['userName'] = $this->genereatUserName(self::$formData['firstName'], self::$formData['lastName']);
            
            // Hash the password
            self::$formData['password'] = password_hash(self::$formData['password'], PASSWORD_DEFAULT);

            // Add user profile image as default
            self::$formData['profileImg'] = 'avatar.png';

             // Add user cover image as default
             self::$formData['coverImg'] = 'cover-image.jpg';

            if ($this->userModel->register(self::$formData)) {
              // If the (remeber me) was checked
              if (isset($_POST['remember'])) {
                $_SESSION['rememberMe'] = $_POST['remember'];
              }  
              // Create userEmail befor login => Verfication
              if (empty($this->errArr)) {
                
                // Forward msg to Gmail
                // $message = "$userName, you have successfuly created your social account!";
                // $subject = '['.SITENAME."] Welocome to your social account.";
                // $this->verifyModel->sendToMail(self::$formData['email'], $message, $subject);

                flash('register_success', 'You are registered and can log in');
                redirect('login');
              }
            }
          }
      }
    }

    // Make sure errors are empty
    private function isErrorsEmpty() {
      if(empty($this->errArr)) {
        return true;
      } else {
        return false;
      }
    }

    // Validate the FirstName
    private function validateFirstName($firstName) {
      $min = 3; $max = 20;

      if (empty($firstName)) {
        ConstantData::$firstNameErr = "FirstName is required!";
        return array_push($this->errArr, ConstantData::$firstNameErr);
    
      } else if (strlen($firstName) < $min) {
        ConstantData::$firstNameErr = "FirstName must be more than $min charecters";
        return array_push($this->errArr, ConstantData::$firstNameErr);

      } else if (strlen($firstName) > $max) {
        ConstantData::$firstNameErr = "FirstName must be less than $max charecters.";
        return array_push($this->errArr, ConstantData::$firstNameErr);
      }
    }
    
    // Validate the lastName
    private function validatelastName($lastName) {
      $max = 10;

      if (empty($lastName)) {
          ConstantData::$lastNameErr = "lastName is required!";
          return array_push($this->errArr, ConstantData::$lastNameErr);
      
      } else if (strlen($lastName) > $max) {
          ConstantData::$lastNameErr = "lastName must be less than $max charecters.";
          return array_push($this->errArr, ConstantData::$lastNameErr);
      }
    }

    // Create a username
    private function genereatUserName($firstName, $lastName) {
      if (!empty($firstName) && !empty($lastName)) {
        // Check for empty => errors
        if(empty(ConstantData::$firstNameErr) && empty( ConstantData::$lastNameErr)) {

          $username = '';
          // Seperating the firstName by space
          $nameExt = explode(' ',  $firstName);
          // Take the first string
          $firstPiece = array_shift($nameExt);
          // Covert to lower case
          $username = strtolower($firstPiece. "_" . $lastName);

            // If username exist in DB
            if ($this->userModel->findIndexByCol('users', 'username', $username)) {
              $randomNum = "";
              // Make changes to username randomly
              for ($i = 1; $i <= 3; $i++) { 
                $randomNum .= rand(1,3);
              }
              $username .= $randomNum;
            }
          return $username;
        }
      }
    }
    
    // Validate the Email
    private function validateEmail($email) {
      if (empty($email)) {
          ConstantData::$emailErr = "Email is required!";
          return array_push($this->errArr, ConstantData::$emailErr);
      
          // If email was not valid
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          ConstantData::$emailErr = "Please enter a valid @Email.";
          return array_push($this->errArr, ConstantData::$emailErr);
        
          // If email is not real => fake
      // } else if (!$this->verifyModel->isEmailReal($email)) {
      //     ConstantData::$emailErr = "Wrong email address(Gmail).";
      //     return array_push($this->errArr, ConstantData::$emailErr);
          
          // If email exists (invalid)
      } else if ($this->userModel->findUserByEmail($email)) {
          ConstantData::$emailErr = "@Email already exists.";
          return array_push($this->errArr, ConstantData::$emailErr);
      }
    }

    // Validate the password
    private function validatePassword($password, $rePassword) {
      $min = 3; $max = 20;

      if (empty($password)) {
          ConstantData::$passwordErr = "Password is required!";
          return array_push($this->errArr, ConstantData::$passwordErr);
      
      } else if (strlen($password) < $min) {
          ConstantData::$passwordErr = "Password must be at least $min characters.";
          return array_push($this->errArr, ConstantData::$passwordErr);

      } else if (strlen($password) > $max) {
          ConstantData::$passwordErr = "Password must be at more than $max characters.";
          return array_push($this->errArr, ConstantData::$passwordErr);

      } else if (preg_match("/[^A-Za-z0-9]/", $password)) {
        ConstantData::$passwordErr = "Password must be letters or digits.";
        return array_push($this->errArr, ConstantData::$passwordErr);
      } 
    }

    // Validate the confirm-password
    private function validateConfirmPassword($password, $rePassword) {

      if (empty($rePassword)) {
          ConstantData::$rePasswordErr = "Confirm-Password is required!";
          return array_push($this->errArr, ConstantData::$rePasswordErr);
      
      } else if ($password != $rePassword) {
        ConstantData::$rePasswordErr = "Password don't match.";
        return array_push($this->errArr, ConstantData::$rePasswordErr);
      }
    }

    // Show every input's value in HTML
    public static function showInputValue($input) {
      if (empty(self::$formData[$input])) {
        return self::$formData[$input] = "";
      } else {
        return self::$formData[$input] = self::$formData[$input];
      }
    }

    // Show error depend on validation of the form
    public function showError($error) {
      if (in_array($error, $this->errArr)) {
          return "<small class='invalid-feedback'>$error</small>";
      }
    }

    // Login user
    public function login() {
      if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Init data
        self::$formData =[
          'email' => $this->formSanitaizer($_POST['email']),
          'password' => $this->formSanitaizer($_POST['password'])
        ];

        $this->LoginEmail(self::$formData['email']);
        $this->LoginPassword(self::$formData['password']);

        // Make sure errors are empty
        if(empty(ConstantData::$emailErr) && empty(ConstantData::$passwordErr)) {

          // Check and set logged in user
          $loggedInUser = $this->userModel->login(self::$formData['email'], self::$formData['password']);

          if ($loggedInUser) {
             // Create Session
             $this->createUserSession($loggedInUser);
          } else {
              ConstantData::$passwordErr = "incorrect password.";
              return array_push($this->errArr, ConstantData::$passwordErr);
          }
        }
      }
    }
  
    // Validate the login Email
    private function LoginEmail($email) {
      if (empty($email)) {
          ConstantData::$emailErr = "Please enter @email!";
          return array_push($this->errArr, ConstantData::$emailErr);
      
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          ConstantData::$emailErr = "Please enter a valid @Email.";
          return array_push($this->errArr, ConstantData::$emailErr);
        
          // If email exists (valid)
      } else if (!$this->userModel->findUserByEmail($email)) {
          ConstantData::$emailErr = "No user found!";
          return array_push($this->errArr, ConstantData::$emailErr);
      } 
    }

    // Validate the Login password
    private function LoginPassword($password) {

      if (empty($password)) {
          ConstantData::$passwordErr = "Enter your password!";
          return array_push($this->errArr, ConstantData::$passwordErr);
      
      } else if (preg_match("/[^A-Za-z0-9]/", $password)) {
        ConstantData::$passwordErr = "Password must be letters or digits.";
        return array_push($this->errArr, ConstantData::$passwordErr);
      }
    }

    // Reset Password 
    public function resetPassword() {
      $email = ''; $verify = '';
      if (POST_REQUEST() && isset($_POST['EmailSub'])) {

        self::$formData = [
            // Sanitaize the email
          'email' => $this->formSanitaizer($_POST['email'])
        ];

        $this->LoginEmail(self::$formData['email']);

          // Check the requirements
          if ($this->isErrorsEmpty()) {
            // OTPDone => to show verifucation UI
            ConstantData::$OTPDone = true;

            // Session variable for verifying section
            $_SESSION['email'] = self::$formData['email'];

            // Generate random verification code
            $verify_num = mt_rand(10000, 99999);

            $data = [
              'email' => self::$formData['email'],
              'verifyCode' => $verify_num,
              'verified' => '0'
            ];
            $this->userModel->insertToResPass($data);

            // $message = "Your SOCIALMANZOOR verification code is: ". $verify_num;
            // $subject = '['.SITENAME."] verify your account.";
            // $this->verifyModel->sendToMail(self::$formData['email'], $message, $subject);
            flash('verify_success', 'Verfication code has been successfuly sent to: '.self::$formData['email']);
          }
      } 
    }

    // Veriying the code
    public function verifyingCode() {
      if (POST_REQUEST() && isset($_POST['VerifySub'])) {
      
        self::$formData = [
          // Sanitaize the email
          'verify' => $this->formSanitaizer($_POST['verify'])
        ];
       
        // Check verification requirement
        $this->verificationCode(self::$formData['verify']) ?
        flash('verify_error', 'Verfication code is Wrong or Empty!') : true;

          // Check the isErr = 1
          if ($this->isErrorsEmpty()) {
             // If verify-code was exist/true
             if ($this->userModel->findIndexByCol('resetpassword', 'verification', self::$formData['verify'])) {

              $data = [
                'email' => $_SESSION['email'],
                'verify' => self::$formData['verify']
              ];
              
              // Update the verified => 1
              $this->userModel->updateByVerified($data);
              redirect('changePass.php');
             } 
          } 
      }
    }

    // Validate the Verification code 
    private function verificationCode($verifyNum) {
      if (empty($verifyNum)) {
          ConstantData::$verifyErr = "Please enter verification-code!";
          return array_push($this->errArr, ConstantData::$verifyErr);
      
      } else if (!$this->userModel->findIndexByCol('resetPassword', 'verification', $verifyNum)) {
          ConstantData::$verifyErr = "Verification code is wrong!";
          return array_push($this->errArr, ConstantData::$verifyErr);
      } 
    }

    // find data By table Col
    public function singleUser() {
      return $this->userModel->singleUser();
    }

    // Create User Session
    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;
      $_SESSION['isLoggedIn'] = 1;
      redirect('home');
    }

    // Logout & unset the sessions
    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('login'); 
    }

    // Return user by email => (Verfication)
    public function verificationEmail() {
      // If @email was empty 
      empty($_SESSION['email']) ? $email = '' : $email = $_SESSION['email']; 
      return $this->userModel->verificationEmail($email);
    }

    // Extends FormSaitizer() => Verifyz class
    // public function FormVerifySanitaizer($link) {
    //   return $this->formSanitaizer($link);
    // }
    
}