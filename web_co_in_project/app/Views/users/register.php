<div class="container" style="margin-top:5px;box-shadow:2px 2px 6px black;">
<br>
<?php echo \Config\Services::validation()->listErrors(); ?>
<?php if(!empty(session()->getFlashdata('fail'))){ ?>
<div class="alert alert-danger"><?php echo session()->getFlashdata('fail'); ?></div>
<?php } ?>

<form method = "post" action="<?php echo base_url('users/register'); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<h5>Fields with "<b style="color:red;">*</b>" are mandatory</h5>
<hr>
<h3>Personal Details:</h3>
<div class = "row">
  <div class="col-md-6">
<div class="form-group">
    <label for="users_first_name">First Name:<b style="color:red;">*</b></label>
    <input type="text" class="form-control" placeholder="Enter your first name" id="users_first_name" name="users_first_name" value="<?php echo set_value('users_first_name'); ?>">
  </div>
  </div>
  <div class="col-md-6">
<div class="form-group">
    <label for="users_last_name">Last Name:<b style="color:red;">*</b></label>
    <input type="text" class="form-control" placeholder="Enter your last name" id="users_last_name" name="users_last_name" value="<?php echo set_value('users_last_name'); ?>">
  </div>
  </div>
</div> 
<div class="form-group">
    <label for="users_email">Email address:<b style="color:red;">*</b></label>
    <input type="text" class="form-control" placeholder="Enter your email address" id="users_email" name="users_email" value="<?php echo set_value('users_email'); ?>">
  </div>  
<h4>Contact Number</h4>
<div class="row">

 <div class="col-md-2">
  <div class="form-group">
    <label for="users_country_code">Country Code:<b style="color:red;">*</b></label>
    <input type="number" class="form-control" placeholder="Country Code" id="users_country_code" name="users_country_code" value="<?php echo set_value('users_country_code'); ?>" > 
  </div>
</div> 
  <div class="col-md-10">
  <div class="form-group">
    <label for="users_phone_number">Phone Number:<b style="color:red;">*</b></label>
    <input type="number" class="form-control" placeholder="Enter your contact number" id="users_phone_number" name="users_phone_number" value="<?php echo set_value('users_phone_number'); ?>">
  </div>
</div>  
</div>  
  
    <div class="form-group">
    <label for="users_password">Password:<b style="color:red;">*</b></label>
    <input type="password" class="form-control" placeholder="Enter your password" id="users_password" name="users_password" value="<?php echo set_value('users_password'); ?>">
  </div>
  <div class="form-group">
    <label for="users_re_password">Re-enter Password:<b style="color:red;">*</b></label>
    <input type="password" class="form-control" placeholder="Re-enter your password" id="users_re_password" name="users_re_password" value="<?php echo set_value('users_re_password'); ?>">
  </div>
  <hr>
  <h3>Business Details:</h3>
  <div class="form-group">
    <label for="users_business_name">Business Name:<b style="color:red;">*</b></label>
    <input type="text" class="form-control" placeholder="Enter your business name" id="users_business_name" name="users_business_name" value="<?php echo set_value('users_business_name'); ?>">
  </div>
  <div class="form-group">
    <label for="users_business_address">Business Address:<b style="color:red;">*</b></label>
    <input type="text" class="form-control" placeholder="Enter your business address" id="users_business_address" name="users_business_address" value="<?php echo set_value('users_business_address'); ?>" >
  </div>
  <div class="form-group">
  <label for="bus_map">Business Map Location (Please specify the "Business Address" for more precision):</label>
 <div id="bus_map_location">
	<iframe width="100%" height="400" src="https://maps.google.com/maps?output=embed" id="bus_map"></iframe>
  </div>
   </div>
  <div class="form-group">
    <label for="users_website_url">Website URL:<b style="color:red;">*</b></label>
    <input type="text" class="form-control" placeholder="Enter your website url" id="users_website_url" name="users_website_url" value="<?php echo set_value('users_website_url'); ?>" > 
  </div>
  <div class="form-group">
  <label for="users_logo">Business Logo:<b style="color:red;">*</b></label>
	<input type="file" name="users_logo" id="users_logo"/>
  </div>
  
  
   
  <input type = "submit" />
  
 <p><a href="<?php echo site_url('users/login'); ?>" >Click Here</a> if you already have an account.</p>
</form>
 <br>
</div>
<script>
var timer = "";

$('#users_business_address').keyup(function(){
			var address = $('#users_business_address').val();
			clearTimeout(timer);
			timer = setTimeout(function(){ajaxmap(address)}, 2000);
			
	});
	
$('#users_business_address').keydown(function(){
	clearTimeout(timer);
})	

function ajaxmap(address){
	if(address.length > 10)
		{
			$.ajax({
						url:"<?php echo site_url('users/map'); ?>",
						method:"POST",
						data:{address},
						beforeSend:function(data){
							$("#bus_map_location").html('<span class="spinner-border"></span>');
						},
						success:function(data){
							$("#bus_map_location").html(data);
						}
					})
		}
}

	
</script>
