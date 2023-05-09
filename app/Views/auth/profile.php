<?= $this->extend('auth/layouts/default') ?>

<?= $this->section('main') ?>

  <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-info rounded shadow-sm">
   

    
  </div>
  <div class="row p-3 my-3">
    
      <div class="card p-3 my-3 col-sm-12 col-lg-5">

        <div class="mb-2 text-center">
       
        <?php 

        if($userData["avatar"] && file_exists(FCPATH .'uploads/'.$userData["avatar"])): ?>
          <img  src="<?= site_url('uploads/'.$userData["avatar"])?>" alt="Thumbnail Image" class="rounded-circle img-fluid" width="250px" height="250px"/>

          <?php else: ?>
          <img src="<?= site_url('uploads/no-image.jpg')?>"  alt="Thumbnail Image" class="rounded-circle" width="250px" height="250px"/>

        <?php endif; ?>
        
        </div><!--/third column-->

      <form action="<?= site_url('update-image'); ?>"  method="POST" enctype="multipart/form-data" accept-charset="UTF-8" onsubmit="updateProfile.disabled = true; return true;">
        <?= csrf_field() ?>
        

        <div class="form-group row mt-3">
          
          <div class="col-sm-10">
            <input type="file" name="avatar" class="form-control col-md-6 text-capitalize" value="<?= $userData["avatar"] ?>">
          </div>
        </div>

        

        <div class="form-group row">
          <div class="col-sm-10">
            <button name="updateProfile" type="submit" class="btn btn-primary">Update Image</button>
          </div>
        </div>
      </form>
    </div>


    <div class="card p-3 my-3 col-sm-12 col-lg-7">

          
      <form action="<?= site_url('update-profile'); ?>" method="POST" accept-charset="UTF-8" onsubmit="updateProfile.disabled = true; return true;">
        <?= csrf_field() ?>
      
        <div class="form-group row mt-3">
          <label class="col-sm-2 col-form-label">First Name</label>
          <div class="col-sm-10">
            <input type="text" name="firstname" class="form-control col-md-10 text-capitalize" value="<?= $userData["firstname"] ?>">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Last Name</label>
          <div class="col-sm-10">
            <input type="text" name="lastname" class="form-control col-md-10 text-capitalize" value="<?= $userData["lastname"] ?>">
          </div>
        </div>

        <h6 class="pb-2 mb-0 mt-4">Contact Info</h6>

        <div class="form-group row mt-3">
          <label class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="text" name="email" class="form-control col-md-10 text-lowercase" value="<?= $userData["email"] ?>">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-10">
            <button name="updateProfile" type="submit" class="btn btn-primary">Update Profile</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card p-3 my-3">
    <form action="<?= site_url('change-password'); ?>" method="POST" accept-charset="UTF-8" onsubmit="changePassword.disabled = true; return true;">
      <?= csrf_field() ?>
      <h6 class="pb-2 mb-0 mt-4">Login Access</h6>

      <div class="form-group row mt-3">
        <label class="col-sm-2 col-form-label">Current Password</label>
        <div class="col-sm-10">
          <input type="password" name="password" class="form-control col-md-6" value="" minlength="5" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">New Password</label>
        <div class="col-sm-10">
          <input type="password" name="new_password" class="form-control col-md-6" value="" minlength="5" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Confirm New Password</label>
        <div class="col-sm-10">
          <input type="password" name="new_password_confirm" class="form-control col-md-6" value="" minlength="5" required>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-10">
          <button name="changePassword" type="submit" class="btn btn-primary">Update Password</button>
        </div>
      </div>
    </form>
  </div>

<?= $this->endSection() ?>