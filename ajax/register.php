<?php
require_once (getenv("DOCUMENT_ROOT")."/functions/include.php");
if (!u()){
?>
<?php
if ($_POST[gebruiker] == 'register'){
?>	
<div class="shoping">
	 <div class="container">
		 <div class="shpng-grids">
			 <div class="col-md-12 shpng-grid">
				 <h3>Gratis Clouds</h3>
				 <p>Bij Registratie krijg u 50 Clouds Gratis van ons </p>
			 </div>
			 <div class="clearfix"></div>
		 </div>
	 </div>
</div>
	 <div class="registration">
			 <h2>Nieuwe Gebruiker ? <span> Registreer Nu </span></h2>
			 <div>
			 <!-- Form -->
				<form action="../invoer" method="post">
				<input type="hidden" name="register" value="register">
					<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label for="user">Gebruikersnaam of E-mail* :</label>
													<input name="user" required="required" type="text" class="form-control" placeholder="Email of Gebruikersnaam">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-8 col-sm-8">
												<label for="tel">Telefoonnummer</label>
													<input name="tel"type="text" class="form-control" placeholder="Telefoon Nummer">
											</div>
											<div class="col-md-4 col-sm-4">
												<label for="birth">Geboorte Datum*</label>
													<input type="date" name="birth" class="form-control" required>
											</div>
										</div>
									</div>		
									<div class="row">
										<div class="form-group">
											<div class="col-md-6 col-sm-6">
												<label for="pass1">Wachtwoord *</label>
													<input name="pass1" required class="form-control" type="password"  placeholder="Wachtwoord">
											</div>
											<div class="col-md-6 col-sm-6">
												<label for="pass2">Wachtwoord Bevestigen *</label>
													<input name="pass2" required  class="form-control"type="password" placeholder="Herhaal Wachtwoord">
											</div>
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="form-group">
												<div class="col-md-6 col-sm-6">
												<label for="vn">Voornaam *</label>
													<input name="vn" type="text"required  class="form-control" placeholder="John">
											</div>
											<div class="col-md-6 col-sm-6">
												<label for="an">Achternaam *</label>
													<input name="an" type="text" required  class="form-control" placeholder="Doe">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-7 col-sm-7">
												<label for="adress">Adres*</label>
													<input name="adress" type="text"  required  class="form-control" placeholder="Straatnaam">
											</div>
											<div class="col-md-3 col-sm-3">
												<label for="number">Nummer*</label>
													<input name="number"  type="text" required  class="form-control" placeholder="125">
											</div>
											<div class="col-md-2 col-sm-2">
												<label for="bus">Bus</label>
													<input name="bus" type="text" class="form-control" placeholder="3">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-md-4 col-sm-4">
												<label for="postcode">Postcode*</label>
													<input name="postcode" type="text" required  class="form-control" placeholder="1000">
											</div>
											<div class="col-md-8 col-sm-8">
												<label for="gemeente">Gemeente*</label>
													<input name="gemeente" type="text" required  class="form-control" placeholder="Gemeente">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
												<label for="land">Land*</label>
													<select class="form-control" name="land">
													<option value="be">Belgie</option>
													<option value="nl">Nederland</option>
													</select>
											</div>
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="form-group">
											<div class="col-md-12 col-sm-12">
											<?php $code = rand();?>
											<input type="hidden" name="code" value="<?php echo $code ?>">
												<div class="col-md-4">
													<label for="checkcode">
														<button type="button" class="btn btn-danger" id='coder'>Antibot knop </button>
													</label>
												</div>
												<div class="col-md-8">
												<label for="checkcode">AntiBot Code*</label>
														<input name="checkcode" id="codechecker" type="text" placeholder="klik op knop voor de code" readonly="readonly">
												</div>
											</div>
											</div>
										</div>
									<hr />
									<br />
									<input class="checked-agree" required="required" type="checkbox" name="checkbox">Bij het registreren ga ik akoord met de  <a href="tos.php">Algemene Voorwaarden</a>.<br /><br />
								<div class="row">
									<div class="col-md-12">
										<button type="submit" name="userregister" class="btn btn-primary regi"><i class="fa fa-check"></i> REGISTER</button>
									</div>
								</div>
				</form>
				<!-- /Form -->
			 </div>
			 			<script>
$(document).ready(function(){
	 $('.regi').hide();
    $("#coder").click(function(){
        $("#codechecker").val("<?php echo $code ?>");
		$('.regi').show();
    });
});
</script>
		 </div>
<?php
}
}
?>