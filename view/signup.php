<?php 
  require_once '../bootstrap.php';
  $pageTitle = "SignUp | ". SITENAME;
  require_once 'inc/header.php';

  $objUser = new Users;

  if (isset($_POST['signUp'])) {
     $objUser->register();
  } 
  
?>

 <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>Create An Account</h2>
        <p>Please fill out this form to register with us</p>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" id="register-form">
        <div class="form-group">
            <label for="firstName">FirstName: <sup>*</sup></label>
            <input type="text" name="firstName" class="form-control form-control-lg <?php echo (!empty($objUser->showError(ConstantData::$firstNameErr))) ? 'is-invalid' : ''; ?>" 
              value="<?= Users::showInputValue('firstName');?>">
            <?php echo $objUser->showError(ConstantData::$firstNameErr);?>
          </div>
          <div class="form-group">
            <label for="lastName">LastName: <sup>*</sup></label>
            <input type="text" name="lastName" class="form-control form-control-lg <?php echo (!empty($objUser->showError(ConstantData::$lastNameErr))) ? 'is-invalid' : ''; ?>" 
              value="<?= Users::showInputValue('lastName');?>">
            <?php echo $objUser->showError(ConstantData::$lastNameErr);?>
          </div>
          <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($objUser->showError(ConstantData::$emailErr))) ? 'is-invalid' : ''; ?>"
            value="<?= Users::showInputValue('email');?>">
             <?php echo $objUser->showError(ConstantData::$emailErr);?>
          </div>
          <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" id="password" name="password" class="form-control form-control-lg <?php echo (!empty($objUser->showError(ConstantData::$passwordErr))) ? 'is-invalid' : ''; ?>" 
            value="<?= Users::showInputValue('password');?>">
             <?php echo $objUser->showError(ConstantData::$passwordErr);?>
          
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password: <sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($objUser->showError(ConstantData::$rePasswordErr))) ? 'is-invalid' : ''; ?>"
            value="<?= Users::showInputValue('confirm_password');?>">
             <?php echo $objUser->showError(ConstantData::$rePasswordErr);?>
        
          </div>

          <div class="row">
            <div class="col-md-12">
              <input type="submit" name="signUp" value="Register" class="btn btn-success btn-block">
            </div>
            <div class="col-md-12">
            <button type="submit" class="btn-form">Signup</button>
               <input type="checkbox" class="form-checkbox" id="check" name="remember">
               <label for="check">Remember me</label>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require_once 'inc/footer.php' ;?>n