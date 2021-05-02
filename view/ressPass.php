<?php 
  require_once '../bootstrap.php';
  $pageTitle = "Login | ". SITENAME;
  require_once 'inc/header.php';
  
  $objUser = new Users;

  if (isset($_POST['EmailSub'])) {
    $objUser->resetPassword();
  } else if (isset($_POST['VerifySub'])) {
    $objUser->verifyingCode();
  }
?>

<div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
       <?php flash('verify_success'); ?>
       <?php flash('verify_error'); ?>
       
        <h2>Verify your account</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($objUser->showError(ConstantData::$emailErr))) ? 'is-invalid' : ''; ?>"
            value="<?= Users::showInputValue('email');?>" <?= ConstantData::$OTPDone ? 'readonly' : '' ;?>
            placeholder="<?= Users::showInputValue('email');?>">
             <?php echo $objUser->showError(ConstantData::$emailErr);?>
          </div>

            <?php if (ConstantData::$OTPDone) :?>
          <div class="form-group">
            <label for="Verify">Verify: <sup>*</sup></label>
            <input type="text" id="verify" name="verify" class="form-control form-control-lg  <?php echo (!empty($objUser->showError(ConstantData::$verifyErr))) ? 'is-invalid' : ''; ?>" 
            value="<?= Users::showInputValue('verify');?>">
             <?php echo $objUser->showError(ConstantData::$verifyErr);?>
          </div>
          <?php endif ?>
          <div class="row">
            <div class="col">
              <input type="submit" name="<?= ConstantData::$OTPDone ? 'VerifySub' : 'EmailSub' ;?>" class="btn btn-success btn-block">
            </div>
           
          </div>
        </form>
      </div>
    </div>
  </div>

<?php require_once 'inc/footer.php' ;?>