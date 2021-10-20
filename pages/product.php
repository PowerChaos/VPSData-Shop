<?php  require(getenv("DOCUMENT_ROOT")."/functions/database.php");
$defimg = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAFeAlADASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD95KKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAoooo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uJ6uh6Z9VHXtXrCsHVWU7lbkEd6Mdf8AZ6+1AHyfd2sthctDPHJDNH96ORSrL9QeajzivqTWfDGm+IY8X1la3W3+KSPcy/7p/wAaxW+CPhcv/wAgmPd/12fH/oVAHzvDC9xJtjVpGPQKMk16d8L/AIDz3NzHfa5H5FvHgx2rD5pP94dh7HmvUtE8HaX4cA+w2Frasv8AGifN+f3v0rSx82O/TFAAqKkeNq7VAAVeAB6CmzTpbwvJI6xxxqWdmOFUDqSewFOzXgn7RXxl/wCEvupvCOhzF7Vfk1e8jbjA6QRsOD/tEdO9AHG+LfGbfFD4i6hr/wA32FcWenhuogTq+P8Aab589+lQU2C3S2hVI1CRoNqqO1OoAKKKKACiiigD60ooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACvk7U+PGPib/ALDt/wD+j3r6xr5U8RWTaZ478TQSff8A7YupMHriSRnU/THP0oArUUUUAFFFFABQwDo1FFAHXfDr4y6l8PUS3kRtS0kYAgZ/3kA9Yien+6fl969m8G/E/Q/Hsaf2bfRtP/z7Sfu5k/4CeTXzXUd3Zw3p/eLub+8R835gigD647UHg18uab468TaEm2x8SapCnpOyXS/lIrGr/wDwu7xwBga5b59Tp8f+NAH0oeBntWH4z+JGh/DuyabWtUtbBeqxO5Msx/2I1+ZvwFfOuq/EHxhrq4vPFmprH6WqpbH/AL6jVW/SsO18P2tvdtcMjzXDt8800hllP/Aj/QUAdp8SP2g9a+Jkcmn6Ilz4f0Z8rLdO2L25H+zj/VL7DmuS03ToNJslgt0WONcsQATuPck9STU4Py7eF+gooAKKKKACiiigAozRU1hayX95HbouXuHCAAc89PzoA+rqKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAryL9oP4XzXWo/8JDpsckzSRrFewoMs+D8soA5zt4Neu0H5lKtu5BUg4INAHyWrb13L8yjqRRX0V4j+C/h/xNcNNJava3DH/WWpCfp0rG/4Zn0H/n81j/v7H/8AEUAeHUV7j/wzPoP/AD+ax/39j/8AiKP+GZ9B/wCfzWP+/sf/AMRQB4dRXuP/AAzPoP8Az+ax/wB/Y/8A4ij/AIZn0H/n81j/AL+x/wDxFAHh1Fe4/wDDM+g/8/msf9/Y/wD4ij/hmfQf+fzWP+/sf/xFAHh1Fe4/8Mz6D/z+ax/39j/+Io/4Zn0H/n81j/v7H/8AEUAeHUV7j/wzPoP/AD+ax/39j/8AiKP+GZ9B/wCfzWP+/sf/AMRQB4dRXuP/AAzPoP8Az+ax/wB/Y/8A4ij/AIZn0H/n81j/AL+x/wDxFAHh1Fe4/wDDM+g/8/msf9/Y/wD4ij/hmfQf+fzWP+/sf/xFAHh1Fe4/8Mz6D/z+ax/39j/+Io/4Zn0H/n81j/v7H/8AEUAeHfxY7noPWvTPgN8NJb7U4davIdtrasDbo4wZX7HnqB6122g/Arw/4fnEn2d7tl6G5beP++VwtdjGnlqoVQu35e21R7AUALRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB//9k=';
		if ($_SESSION[ERROR] != "")
		{	
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}
if (isset($_GET['product'])) {
	$id = str_replace("-", " ", $_GET[product]);
	try {
		$stmt = $db->prepare("SELECT * FROM products WHERE name = :id");
		$stmt->execute(array(':id' => $id));
		$prod = $stmt->fetch(PDO::FETCH_ASSOC);
		$rat = $db->prepare("SELECT * FROM rating WHERE pid = :pid");
		$rat->execute(array(':pid' => $prod[id]));
		$ratingcount = $rat->RowCount();
		$rating = $rat->fetchall(PDO::FETCH_ASSOC);
		$imgprod = $db->prepare("SELECT * FROM images WHERE pid = :pid ORDER BY RAND()");
		$imgprod->execute(array(':pid' => $prod[id]));
		$img = $imgprod->fetchall(PDO::FETCH_ASSOC);
		$count = $imgprod->RowCount();
		$starcount = "0";
		$totstar = "0";
		foreach ($rating AS $star)
		{
			$starcount += $star[rating];
		}
		$totstar = ($ratingcount > '0')?($starcount / $ratingcount):"0";
		
				//stock Weergave
		$stock = $db->prepare("SELECT * FROM stock WHERE pid = :stock ORDER BY naam");
		$stock->execute(array(':stock' => $prod[id]));
		$amount = $stock->fetchall(PDO::FETCH_BOTH);
		sort($amount);
		//Cloud Shop
		$cl = $db->prepare("SELECT * FROM bonus WHERE pid = :pid AND datum > :tm");
		$cl->execute(array(':pid' => $prod[id],':tm' => time(),));
		$clknop = $cl->fetch(PDO::FETCH_ASSOC);
	if ($_SESSION[naam] != ""){
								$stmt3 = $db->prepare("SELECT * FROM gebruikers WHERE naam = :user");
								$stmt3->execute(array(':user' => $_SESSION[naam]));
								$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
								$stmt4 = $db->prepare("SELECT * FROM discount WHERE clouds <= :groep ORDER BY clouds DESC LIMIT 1");
								$stmt4->execute(array(':groep' => $row3[punten]));
								$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
								$disc = ($row4[discount] =="")?"0":$row4[discount];
								$korting = floor($prod[prijs]);
								$bonus = floor(($korting / 100) * $disc);
								$clouds = " <div class='clearfix'></div> <li class='active'>Verdien <clouds id='clouds'>".$korting."</clouds> <i class='material-icons'>filter_drama</i></li>";
								$tot = $korting + $bonus;
								$totbonus = "<li>+ <d id='disc'>$disc</d> % Bonus =  <t id='bon'>$tot</t> <i class='material-icons'>filter_drama</i></li><div class='clearfix'></div>";
	}							
	}
	catch(Exception $e) {
		echo '<h2><font color=red>';
		var_dump($e->getMessage());
		die ('</h2></font> ');
	}	
}
?>
<div class="single-sec">
	 <div class="container">
		 <!-- start content -->	
		 <div class="col-md-9 det">
				 <div class="single_left">
					 <div class="flexslider">
							<ul class="slides">
							<?php
							if ($count < '1')
							{ ?>
								<li data-thumb="<?php echo $defimg ?>">
									<img src="<?php echo $defimg ?>" />
								</li>
							<?php }
							else{
							foreach ($img as $image)
							{ ?>
								<li data-thumb="<?php echo ($image[img]=="")?$defimg:$image[img] ?>">
									<img src="<?php echo ($image[img]=="")?$defimg:$image[img] ?>" />
								</li>
							<?php } }?>
							</ul>
						</div>

							<script>
						// Can also be used with $(document).ready()
						$(window).load(function() {
						  $('.flexslider').flexslider({
							animation: "slide",
							controlNav: "thumbnails"
						  });
						});
						</script>
				 </div>
				  <div class="single-right">
					 <h3><?php echo $prod['name']?></h3>
					  <div class="id"><h4>Category: <?php echo $prod['cat']?></h4></div>
					  <?php $sk = strtolower($prod[merk]);?>
					 <div class="id"><h4>Merk: <a href="//<?php echo $_SERVER['SERVER_NAME']."/".$sk?>.html"><?php echo $prod[merk] ?></a></h4></div>
					  <form action="" class="sky-form">
						     <fieldset>					
							   <section>
							    <div class="id">
							     <div class="rating">
								 <h4><input id="star-rating-value" value="<?php echo round($totstar) ?>" type="number">( <?php echo $ratingcount ?> Stemmen )</input></h4>
								<!-- <input id="star-rating" name="star-rating" class="rating rating-loading" value="<?php echo $prod['rating']?>" data-min="0" data-max="5" data-step="1">  -->
								 </div>
								 </div>
							  </section>
						    </fieldset>
					  </form>
					  <div class="cost">
					  								 <?php
													 $kleur =  ($prod[cat] == "LIQUIDS")?"Nicotine":"Kleur";
										echo "Selecteer $kleur : <select id='kleur' name='kleur'>";
											foreach ($amount as $stok)
											{
											echo "<option value='$stok[naam]'>$stok[naam]</option>";
											}
											?>
										</select><div class='clearfix'></div><br>
										Selecteer Aantal :<aantal id='aantal'></aantal><br><br>
						<div class="clearfix"></div>						
						 <div class="prdt-cost">
							 <ul>							 
								 <?php echo $clouds ?>
								 <div class="clearfix"></div>
								 <?php echo $totbonus ?>
								 <input type="hidden" value="<?php echo $prod[prijs] ?>" id='check'>
								 <input type="hidden" value="<?php echo $clknop[prijs] ?>" id='clcheck'>
								 <button type="button" class="btn-lg btn-primary text-center kleur" data-toggle="modal" data-target="#modal" id="<?php echo $prod['id'] ?>" onclick="shop(this.id,'toevoegen')">Koop Nu voor &euro; <prijs id='prijs'><?php echo $prod[prijs] ?></prijs>  
								 <?php if ($clknop[prijs] != ""){ ?>
								 of <free id='free'><?php echo $clknop[prijs]?></free> <i class='material-icons'>filter_drama</i>
								 <?php } ?>
								 </button>
							 </ul>
						 </div>
						 <div class="clearfix"></div>
					  </div>
					  <div class="single-bottom1">
						<h6>Product Omschrijving</h6>
						<p class="prod-desc"><?php echo $prod[over]?></p>
					 </div>					 
				  </div>
				  <div class="clearfix"></div>
		</div>
	</div>
</div>

<div class="featured">
	 <div class="container">
		 <h3>Onze Selectie <?php echo $prod['cat']?></h3>
		 <div class="feature-grids"> <!-- Random producten -->
		 <?php
		
									try {	
										$relprod2 = $db->prepare("SELECT * FROM products WHERE cat = :cat ORDER BY RAND() LIMIT 3");
										$relprod2->execute(array('cat' => $prod[cat]));
										$rel2 = $relprod2->fetchall(PDO::FETCH_ASSOC);
									foreach($rel2 as $related2) {
										$imgprod = $db->prepare("SELECT * FROM images WHERE pid = :pid ORDER BY RAND() LIMIT 1");
										$imgprod->execute(array(':pid' => $related2[id]));
										$img = $imgprod->fetch(PDO::FETCH_ASSOC);
													$seoproduct = str_replace(" ", "-", $related2[name]);
													$seoproduct = strtolower($seoproduct);
													$seomerk = strtolower($related2[merk]);
									?>
					 <a href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$seomerk.'/'.$seoproduct;?>.html"><div class="product-grid love-grid">
						<div class="more-product"><span> </span></div>						
						<div class="product-img b-link-stripe b-animate-go  thickbox">
						<img src="<?php echo ($img[img]=="")?$defimg:$img[img] ?>" height="280" alt="<?php echo $related2['name'] ?>"/>
						</div>					
						<div class="product-info">
							<div class="product-info-cust prt_name">
								<h4><?php echo $related2['merk']." <br> ".$related2['name'] ?></h4>
								<div class="clearfix"> </div>								
							</div>													
						</div>
					</div></a>
								<?php
									}
									}
									catch(Exception $e) {
										echo '<h2><font color=red>';
										var_dump($e->getMessage());
										die ('</h2></font> ');
									}	
								?>
<div class="clearfix"></div>
</div>
 </div>
</div>
				<script type="text/javascript">
$(document).ready(function(){
										/*$('div select[name=kleur]').change(function(e){
											if ($('div select[name=subject]').val() != ''){
												var kleur = $(this).val();
												$(".kleur").attr('id', kleur);
											}
										});*/
								$('#star-rating-value').rating({
								min: 0,
								max: 5,
								step: 1,
								size: 'sm',
								showClear: false
								});
        
        $('#star-rating-value').on('rating.change', function() { //begin Rating Waarde
			var dat = $('#star-rating-value').val()
			var prod = "<?php echo $prod[id] ?>";
			$.ajax({				
	type: "POST",
	url: "//<?php echo $_SERVER['SERVER_NAME']?>/ajax/voting.php",
	data:'rating='+dat+'&prod='+prod,
	success: function(data){
		//alert(data);
		//alert ("dat " +dat+ "prod"+prod);
		$("#modal").modal('show');
		$("#modalcode").html(data);	
}
	});	
        }); //einde rating
			
				//Select Update
				$( "#aantal" ).load( "//<?php echo $_SERVER['SERVER_NAME'] ?>/ajax/stock.php", {
			kleur: "geen",
			prod: "<?php echo $prod[id] ?>",
		});
		        $('#kleur').on('change', function() { //begin Rating Waarde
			var dat = $('#kleur').val();
			$.ajax({
			type: "POST",
			url: "//<?php echo $_SERVER['SERVER_NAME']?>/ajax/stock.php",
			data:'kleur='+dat,
			success: function(data){
		//alert(data);
		//alert ("item: " +dat+ " en waarde: " +val+ "en kleur : "+kleur+" en qty : "+qty);
		 $('#aantal').html(data);
	}
				});		
				
				
		});
				
}); //einde document Ready		
//Shop Toevoegen
function shop(val, dat) {
	var qty = $( "#qty" ).val();
	var kleur = $( "#kleur" ).val();
	$.ajax({
	type: "POST",
	url: "//<?php echo $_SERVER['SERVER_NAME']?>/ajax/shop.php",
	data:'item='+dat+'&waarde='+val+'&kleur='+kleur+'&qty='+qty,
	success: function(data){
		//alert(data);
		//alert ("item: " +dat+ " en waarde: " +val+ "en kleur : "+kleur+" en qty : "+qty);
		$("#modal").modal('show');
		$("#modalcode").html(data);	
		$('#modal').on('hidden.bs.modal', function () {
window.location.reload();
})
	}
	});		
}				
</script>
		  </div>
	 </div>
</div>
</div>