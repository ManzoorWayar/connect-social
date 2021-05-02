<?php 
  require_once '../bootstrap.php';
  $pageTitle = "Login | ". SITENAME;
  require_once 'inc/header.php';
  
  $objUser = new Users;

  if (isset($_POST['login'])) {
     $objUser->login();
  } 
  
?>

<div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
       <?php flash('register_success'); ?>
        <h2>Login</h2>
        <p>Please fill in your credentials to log in</p>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($objUser->showError(ConstantData::$emailErr))) ? 'is-invalid' : ''; ?>"
            value="<?= Users::showInputValue('email');?>">
             <?php echo $objUser->showError(ConstantData::$emailErr);?>
          </div>
          <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" id="password" name="password" class="form-control form-control-lg  <?php echo (!empty($objUser->showError(ConstantData::$passwordErr))) ? 'is-invalid' : ''; ?>" 
            value="<?= Users::showInputValue('password');?>">
             <?php echo $objUser->showError(ConstantData::$passwordErr);?>
          
          </div>
            <a href="ressPass.php">Forget password</a>
          <div class="row">
            <div class="col">
              <input type="submit" name="login" value="Login" class="btn btn-success btn-block">
            </div>
           
          </div>
        </form>
      </div>
    </div>
  </div>

<?php require_once 'inc/footer.php' ;?>n