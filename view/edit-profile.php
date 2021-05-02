<?php 
 require_once '../bootstrap.php';
 $pageTitle = "Edit-Profile | ". SITENAME;

    $objProfile = new Profiles; 

    $userInfo = $objProfile->userProfile($_SESSION['user_id']);

    if (isset($_POST['updateBtn'])) {
        $objProfile->editProfle();
    }

 require_once 'inc/header.php';
 ?>

    <section id="action" class="py-4 mb-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mr-auto">
                    <a href="home.php" class="btn btn-outline-primary btn-block">
                        <i class="fa fa-arrow-left"></i> Back To Home
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#passwordModal">
                        <i class="fa fa-lock"></i> Change Password
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#" class="btn btn-danger btn-block ml-5" data-toggle="modal" data-target="#deleteAccount">
                        <i class="fa fa-lock"></i> Delete Account
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- PROFILE EDIT -->
    <section id="profile">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="text-center text-info">Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <form action="edit-profile.php" method="POST" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name"></label>
                                            <input type="text" name="firstname" class="form-control"
                                                value="<?= $userInfo->fisrtName;?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" name="lastname" class="form-control"
                                                value="<?= $userInfo->lastName;?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" class="form-control" readonly
                                                value="<?= $userInfo->email;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="education">Education</label>
                                            <input type="tel" name="education" class="form-control"
                                                value="<?= $userInfo->education;?>" placeholder="Education">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" name="country" class="form-control"
                                                value="<?= $userInfo->live;?>" placeholder="country">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="job">Job</label>
                                            <input type="tel" name="job" class="form-control"
                                                value="<?= $userInfo->work;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birthday">Birthday</label>
                                            <input type="date" name="birthday" class="form-control"
                                                value="<?= $userInfo->born;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="age">Age</label>
                                            <input type="text" name="age" class="form-control"
                                                value="<?= $userInfo->age;?>" placeholder="Age...">
                                        </div>
                                    </div>
                                    <div class="col-md-10 ml-5 text-center">
                                        <div class="form-group">
                                            <label for="body">Bio</label>
                                            <textarea class="form-control text-center" name="bio" id="bio">
                                                <?= $userInfo->bio;?>
                                                </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mx-auto">
                                    <input type="submit" value="Save" name="updateBtn"
                                        class="btn btn-primary btn-block" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PASSWORD MODAL -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header mx-auto">
                    <h5 class="modal-title text-success">Change Password</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <label for="password">Current Password</label>
                            <input type="password" class="form-control" name="" id=""
                                placeholder="Enter current-password">
                        </div>
                        <div class="form-group pt-4">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" name="" id="" placeholder="Enter new-password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer mx-auto">
                    <button type="button" class="btn btn-success px-5 py-1">Change</button>
                    <button type="button" class="btn btn-outline-danger px-4 py-1" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Account -->
    <div class="modal fade modal-meduim" id="deleteAccount" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mx-auto">
                    <h5 class="modal-title text-success">Delete Account</h5>
                </div>
                <div class="modal-body">
                    <p class="text-center text-danger">Are you sure to delete this account ?</p>
                </div>
                <form action="edit-profile.php" method="POST">
                    <div class="modal-footer mx-auto">
                        <button type="submit" name="deleteBtn" class="btn btn-outline-success px-4 py-1">Yes, Delete
                            it!</button>
                        <button type="button" class="btn btn-outline-danger px-4 py-1" data-dismiss="modal">NO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'inc/footer.php';?>