<!---->
<div class="clearfix"></div>
	<div class="copywrite">
		<div class="container">
		<div class="row">
		<div class="col-xs-6 text-left">
		Copyright © 2016 Vaporama. All Rights Reserved | Coded by <a href="http://cp.dehost.org/prijs">PowerChaos</a>
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
	   <p class="text-center">Klik hier om Deze Modal te sluiten</p>
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