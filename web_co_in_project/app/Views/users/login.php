<div class="container" style="margin-top:5px;box-shadow:2px 2px 6px black;">
<br>
<?php echo \Config\Services::validation()->listErrors(); ?>
<?php if(!empty(session()->getFlashdata('fail'))){ ?>
<div class="alert alert-danger"><?php echo session()->getFlashdata('fail'); ?></div>
<?php } ?>
<form method = "post" action="<?php echo base_url('users/login'); ?>">
<h3>Login:</h3>
<div class="form-group">
    <label for="users_email">Email address:<b style="color:red;">*</b></label>
    <input type="text" class="form-control" placeholder="Enter your email address" id="users_email" name="users_email" value="<?php echo set_value('users_email'); ?>">
  </div> 
  <div class="form-group">
    <label for="users_password">Password:<b style="color:red;">*</b></label>
    <input type="password" class="form-control" placeholder="Enter your password" id="users_password" name="users_password" value="<?php echo set_value('users_password'); ?>">
  </div>
  <input type = "submit" />
</form>
<p><a href="<?php echo site_url('users/register'); ?>" >Click Here</a> if you don't have an account.</p>
<br>
</div>