<?php
if (u()){
		if ($_SESSION[ERROR] != "")
		{	
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}
require(getenv("DOCUMENT_ROOT")."/functions/database.php");	
$stmt = $db->prepare("SELECT * FROM gebruikers WHERE id=:id");
$stmt->execute(array(':id' => $_SESSION[id]));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
	<div class="registration">
<pre class='alert alert-success fade in text-center' id='statusgebruiker'>
Klik op een veld om te bewerken en duw enter om te bevestigen
</pre>
			 <div class="registration_form">
			 <!-- Form -->
					<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label for="user">Gebruikersnaam of E-mail:</label>
													<input id="naam:<?php echo $result[id]?>" class="form-control" contenteditable="false" readonly value="<?php echo $result[naam] ?>" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-8 col-sm-8">
												<label for="tel">Telefoonnummer</label>
													<input id="tel:<?php echo $result[id]?>" class="form-control" contenteditable="true" value="<?php echo $result[tel] ?>">
											</div>
											<div class="col-md-4 col-sm-4">
												<label for="birth">Geboorte Datum</label>
													<input id="birth:<?php echo $result[id]?>" name="birth" class="form-control" contenteditable="false" readonly value="<?php echo $result[birth]?>">
											</div>
										</div>
									</div>		
									<hr />
									<div class="row">
										<div class="form-group">
												<div class="col-md-6 col-sm-6">
												<label for="vn">Voornaam</label>
													<input id="voornaam:<?php echo $result[id]?>" class="form-control" contenteditable="true" value="<?php echo $result[voornaam] ?>">
											</div>
											<div class="col-md-6 col-sm-6">
												<label for="an">Achternaam</label>
													<input id="achternaam:<?php echo $result[id]?>" class="form-control" contenteditable="true" value="<?php echo $result[achternaam] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-7 col-sm-7">
												<label for="adress">Adres</label>
													<input id="adress:<?php echo $result[id]?>" class="form-control"  contenteditable="true"value="<?php echo $result[adress] ?>">
											</div>
											<div class="col-md-3 col-sm-3">
												<label for="number">Nummer</label>
													<input id="nummer:<?php echo $result[id]?>" class="form-control" contenteditable="true" value="<?php echo $result[nummer] ?>">
											</div>
											<div class="col-md-2 col-sm-2">
												<label for="bus">Bus</label>
													<input id="bus:<?php echo $result[id]?>" class="form-control " contenteditable="true" value="<?php echo $result[bus] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-md-4 col-sm-4">
												<label for="postcode">Postcode</label>
													<input id="postcode:<?php echo $result[id]?>" class="form-control" contenteditable="true" value="<?php echo $result[postcode] ?>">
											</div>
											<div class="col-md-8 col-sm-8">
												<label for="gemeente">Gemeente</label>
													<input id="gemeente:<?php echo $result[id]?>" class="form-control" contenteditable="true" value="<?php echo $result[gemeente] ?>">
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
		if ((val =="") && (field != 'bus:<?php echo $result[id]?>') )
		{
			alert('Lege waarden zijn niet goed');
		}
		else
		{
		$.ajax({
		type: "POST",
		url: "../ajax/dbedit.php",
		data:'field='+field+'&waarde='+val+'&edit=gebruiker',
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
?>