<br>
<div class="container text-right">
<a type="button" href="<?php echo site_url('users/logout');?>" class="btn btn-danger">Logout</a>
</div>
<br>
<div class="container" style="margin-top:5px;box-shadow:2px 2px 6px black;">
<br>

<div id="capture">
	<div class="row">
		<div class="col-md-6">
			<img src="/uploads/<?php echo esc($logo); ?>" style="width:100%;max-height:300px;object-fit:cover;"/>
		</div>
		<div class="col-md-6">
			<div style="margin-bottom:15px;">
				<h2><?php echo esc($first_name); ?>&nbsp<?php echo esc($last_name); ?></h2>
				<h4><?php echo esc($business_name); ?></h4>
			</div>
			<div style="margin-bottom:15px;">
				<p><?php echo esc($contact_number); ?></p>
				<p><?php echo esc($email); ?></p>
			</div>
			<div style="margin-bottom:5px;">
				<p><?php echo esc($website_url); ?></p>
				<p><?php echo esc($business_address); ?></p>
			</div>
		</div>
	</div>
</div>
<br>
</div>
<br>
<div class="container text-center">
<div class="row">
<div class="col-md-6">
<button onclick="doCapture();" class="btn btn-primary">Download Visiting Card</button>
</div>
<div class="col-md-6">
<form method="post" action="<?php echo base_url('users/vcard'); ?>">
<button type="submit" class="btn btn-primary">Download Vcard</button>
</form>
</div>
</div>
<br>
<a href="https://wa.me/?text=<?php echo urlencode($website_url);?>" target="_blank" type="button" class="btn btn-primary">Share on Whatsapp</a>
</div>
<script src="<?php echo base_url('js/html2canvas.js'); ?>"></script>
<script>
function doCapture(){
		window.scrollTo(0,0);
		document.body.style.overflow = 'hidden';
		html2canvas(document.getElementById('capture')).then(function(canvas){
		console.log(canvas.toDataURL("image/jpeg",0.9));
		
		var ajax = new XMLHttpRequest();
		ajax.open("POST","visiting_card",true);
		ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajax.send("image=" + canvas.toDataURL("image/jpeg",0.9));
		
		ajax.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				console.log(this.responseText);
				
				var downloadLink = document.createElement("a");
				downloadLink.href = "/uploads/<?php echo session()->get('users_id'); ?>_visitingcard.jpeg";
				downloadLink.download = "visiting_card.jpeg";

				/*
				* Actually download CSV
				*/
				document.body.appendChild(downloadLink);
				downloadLink.click();
				document.body.removeChild(downloadLink);
			}
		};
	});
}
</script>
</script>