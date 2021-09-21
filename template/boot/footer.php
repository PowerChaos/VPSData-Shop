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
*          File Name        > <!#FN> footer.php </#FN>                                                                 
*          File Birth       > <!#FB> 2021/09/18 00:38:17.379 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/18 03:47:10.401 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/





$session = new Session;
?>

<!---->
<div class="clearfix"></div>
	<div class="copywrite">
		<div class="container">
		<div class="row">
		<div class="col-xs-6 text-left">
		Copyright © 2021 VPS Data. All Rights Reserved | Coded by <a href="https://vpsdata.be">PowerChaos</a>
		</div>
		<div class="col-xs-6 text-right">
		<a href='#' data-toggle="modal" data-target="#modal" id="tos" onclick="tos(this.id);" aria-hidden="true" >TOS</a> | <a href='#' data-toggle="modal" data-target="#modal" id="privacy" onclick="tos(this.id);" aria-hidden="true" >Privacy</a> | <a href='#' data-toggle="modal" data-target="#modal" id="contact" onclick="tos(this.id);" aria-hidden="true" >Contact</a>	
	</div>
		</div>
		</div>
	</div>	
<!-- Modal -->
 <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
       <div class="modal-header alert alert-danger" data-dismiss="modal">
	   <p class="text-center">Close modal</p>
         <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="material-icons">cancel</i><span class="sr-only">Sluiten</span></button> -->
       <!-- <div class="alert alert-danger" id="myModalLabel" data-dismiss="modal" ><p class="text-center">Klik hier om Deze Modal te sluiten</p></div> -->
       </div>
       <div class="modal-body" id="modalcode">
       </div>
    </div>
   </div>
 </div>
<!-- end modal -->
    <!-- Menu Toggle Script -->

	<!-- Footer JS -->
<script>
//Cart Weergeven
function shopcart(val, dat) {
	$.ajax({
	type: "POST",
	url: "//<?php echo $_SERVER['SERVER_NAME']?>/ajax/shopcart.php",
	data:'shop='+dat+'&waarde='+val,
	success: function(data){
		//alert(data);
		//alert ("item: " +dat+ " en waarde: " +val);
		$("#modal").modal('show');
		$("#modalcode").html(data);	
}
	});		
}
//Login/register
function login(val) {
	$.ajax({
	type: "POST",
	url: "//<?php echo $_SERVER['SERVER_NAME']?>/ajax/register.php",
	data:'gebruiker='+val,
	success: function(data){
		//alert(data);
		//alert ("gebruiker: " +val);
		$("#modal").modal('show');
		$("#modalcode").html(data);	
}
	});		
}

//tos contact and privacy
function tos(val) {
	$.ajax({
	type: "POST",
	url: "//<?php echo $_SERVER['SERVER_NAME']?>/ajax/tos.php",
	data:'footer='+val,
	success: function(data){
		//alert(data);
		//alert ("gebruiker: " +val);
		$("#modal").modal('show');
		$("#modalcode").html(data);	
}
	});		
}
$(document).ready(function() {
	//enter prevention
$(".no-enter").keypress(function(e){ return e.which != 13; });
$('.error').hide();
<?php
$error = $session->flash('error');
if ($error)
{
?>
$('.error').show();	
$(".error").html("<?php echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>$error</div>"; ?>");
<?php
}
?>		
//header DropDown Fix
  $('.navbar-header').click(function(){
		var parent = $(this).parent();
		if(parent.hasClass('in')) { 
			parent.removeClass('in');
		$(".navbar-collapse").slideDown();
		} else {
			parent.addClass('in');
		$(".navbar-collapse").slideUp();
		}
	});	

	$('.dropdown-toggle').click(function(){
		var parent = $(this).parent();
		if(parent.hasClass('open')) { 
			parent.removeClass('open'); 
		} else {
			parent.addClass('open');
		}
	});
	
	});
</script>
</body>
</html>