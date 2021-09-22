<?php

/*
<!#CR>
************************************************************************************************************************
*                                                    Copyrigths ©                                                      *
* -------------------------------------------------------------------------------------------------------------------- *
*          Authors Names    > PowerChaos                                                                               *
*          Company Name     > VPS Data                                                                                 *
*          Company Email    > info@vpsdata.be                                                                          *
*          Company Websites > https://vpsdata.be                                                                       *
*                             https://vpsdata.shop                                                                     *
*          Company Socials  > https://facebook.com/vpsdata                                                             *
*                             https://twitter.com/powerchaos                                                           *
*                             https://instagram.com/vpsdata                                                            *
* -------------------------------------------------------------------------------------------------------------------- *
*                                           File and License Informations                                              *
* -------------------------------------------------------------------------------------------------------------------- *
*          File Name        > <!#FN> profiel.php </#FN>                                                                
*          File Birth       > <!#FB> 2021/09/18 00:38:17.367 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/21 23:45:04.376 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/





$perm = new Gebruikers;
$session = new Session;
$db = new Db;
if ($_POST['edit'] == "gebruikers")
{
	$table = $_POST['edit'];
	$field = $_POST['field'];
	$waarde = $_POST['waarde'];
    $split_data = explode(':', $field);
    $value = $split_data[0];
	if (($value == 'phone') && !$perm->validphone($waarde)) {
		echo $waarde.' is not a valid, please use +32 493 48 30 33 format';
	exit;
	}	
$db->ajaxedit($table,$waarde,$field);
exit;
}

if ($perm->check('user')){
$bind = array(':id' => $session->get('id'));	
$result = $db->select('gebruikers','id = :id','',$bind,'fetch');	
?>
<div class="container">
	<div class="registration">
<pre class='alert alert-success fade in text-center' id='statusgebruiker'>
Click on a field to edit it , press ENTER to confirm the new field value
</pre>
			 <div class="registration_form">
			 <!-- Form -->
					<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label for="user">E-mail:</label>
													<input id="naam:<?php echo $result['id']?>" class="form-control" contenteditable="false" readonly value="<?php echo $result['naam'] ?>" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-8 col-sm-8">
												<label for="tel">Telefoonnummer</label>
													<input id="phone:<?php echo $result['id']?>" class="form-control" contenteditable="true" value="<?php echo $result['phone'] ?>">
											</div>
											<div class="col-md-4 col-sm-4">
												<label for="land">Country</label>
													<input id="land:<?php echo $result['id']?>" class="form-control" contenteditable="false" readonly value="<?php echo $result['land'] ?>">
											</div>
										</div>
									</div>		
									<hr />
									<div class="row">
										<div class="form-group">
												<div class="col-md-6 col-sm-6">
												<label for="vn">First Name</label>
													<input id="voornaam:<?php echo $result['id']?>" class="form-control" contenteditable="true" value="<?php echo $result['voornaam'] ?>">
											</div>
											<div class="col-md-6 col-sm-6">
												<label for="an">Last Name</label>
													<input id="achternaam:<?php echo $result['id']?>" class="form-control" contenteditable="true" value="<?php echo $result['achternaam'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-7 col-sm-7">
												<label for="adress">Adress</label>
													<input id="adress:<?php echo $result['id']?>" class="form-control"  contenteditable="true"value="<?php echo $result['adress'] ?>">
											</div>
											<div class="col-md-3 col-sm-3">
												<label for="number">Number</label>
													<input id="nummer:<?php echo $result['id']?>" class="form-control" contenteditable="true" value="<?php echo $result['nummer'] ?>">
											</div>
											<div class="col-md-2 col-sm-2">
												<label for="bus">Bus</label>
													<input id="bus:<?php echo $result['id']?>" class="form-control " contenteditable="true" value="<?php echo $result['bus'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-md-4 col-sm-4">
												<label for="postcode">Zip Code</label>
													<input id="postcode:<?php echo $result['id']?>" class="form-control" contenteditable="true" value="<?php echo $result['postcode'] ?>">
											</div>
											<div class="col-md-8 col-sm-8">
												<label for="gemeente">City</label>
													<input id="gemeente:<?php echo $result['id']?>" class="form-control" contenteditable="true" value="<?php echo $result['gemeente'] ?>">
											</div>
										</div>
									</div>


				<!-- /Form -->
			 </div>
		 </div>


<script>
$(document).ready(function() {
	//DB edit
		$("input[contenteditable=true]").keypress(function(e){
		var message_status = $("#statusgebruiker");
		if (e.which == 13 ){
        var field = $(this).attr("id") ;
        var val = $(this).val() ;
		if ((val =="") && (field != 'bus:<?php echo $result['id']?>') )
		{
			alert('Emtpy value\'s are bad');
		}
		else
		{
		$.ajax({
		type: "POST",
		url: "../x/profiel",
		data:'field='+field+'&waarde='+encodeURIComponent(val)+'&edit=gebruikers',
		success: function(data){
				message_status.show();
				message_status.text(data);
				//hide the message
				//setTimeout(function(){message_status.hide()},5000);
			}
    });
		}
return false;	
}
});


});
</script>
<?php
}
else
{
	$session->flashdata('error','Please login first before accessing this page');
}
?>