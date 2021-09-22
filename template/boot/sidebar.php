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
*          File Name        > <!#FN> sidebar.php </#FN>                                                                
*          File Birth       > <!#FB> 2021/09/18 00:38:17.382 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/18 03:47:40.931 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/
   
$db = new Db;
$perm = new Gebruikers;
$session = new Session;
?>
 <!-- fixed top navbar -->
  <nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
	    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigatie" aria-expanded="false" aria-controls="navigatie">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
	  <a href="../home"> <img src="../img/header.png" alt="VPS Data - Webshop">
	  </a>
      <!-- <a class="navbar-brand" href="../home"><b>Vaporama - World of Vaping</b></a> -->
    </div>
      <!--navbar menu options: shown on desktop only -->
      <div class="navbar-collapse collapse" id="navigatie">
        <ul class="nav yamm navbar-nav">
		  <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Brands<b class="caret"></b></a>
				<ul class="dropdown-menu">
				<li>
				<div class="yamm-content">
                    <div class="row">
			     <?php
												$category = $db->select('products','','','','','cat','cat','cat ASC');
                                                $count = $db->select('products','','','','rowcount','cat','cat','cat ASC');
                                                $count = ($count=='0')?'1':$count;
                                                $div = ceil(12/$count);
                                                $div = ($div%2 != "0")?$div+1:$div;
                                                foreach ($category as $cat) {
                                                    echo "<ul class='col-md-$div list-unstyled'>";
                                                    $naam = $cat['cat'];
                                                    //echo cats
                                                    echo "
													<li><h4>$naam</h4></li>
													<li class='divider'></li>
													";
                                                    //echo subcats
													//subcats query en count
													$cate = array(":cat" =>$naam);
													$subcat = $db->select('products','cat = :cat','',$cate,'','','merk','merk ASC');
                                                    foreach ($subcat as $sub) {
                                                        $seomerk = strtolower($sub['merk']);
                                                        echo "
															<li><a href='//{$_SERVER['SERVER_NAME']}/{$seomerk}.html'>{$sub['merk']}</a></li>
														";
                                                    }
                                                    echo "</ul>";
                                                }
            	?>
					</div>
				</div>
			    </li>
		        </ul>
	        </li>

		  <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li>
					<div class="yamm-content">
						<div class="row">
			  							<?php
                                               $category = $db->select('products','cat !=fillaments','','','','','merk','merk ASC');
                                               $count = $db->select('products','','','','rowcount','cat','cat','cat ASC');
                                                $count = ($count == "0")?'1':$count;
                                                $div = ceil(12/$count);
                                                $div = ($div%2 != "0")?$div+1:$div;
                                                foreach ($category as $cat) {
                                                    echo "<ul class='col-md-$div list-unstyled'>";
                                                    $naam = $cat['merk'];
                                                    //echo cats
                                                    echo "
													<li><h4>{$naam}</h4></li>
													<li class='divider'></li>
													";
                                                    //echo subcats
                                                    $cate = array(":cat" =>$naam);
													$subcat = $db->select('products','cat = :cat AND cat !=fillaments','',$cate,'','','','name ASC');
                                                    foreach ($subcat as $sub) {
                                                        $seoproduct = str_replace(" ", "-", $sub['name']);
                                                        $seoproduct = strtolower($seoproduct);
                                                        $seomerk = strtolower($sub['merk']);
                                                        echo "
															<li><a href='//{$_SERVER['SERVER_NAME']}/{$seomerk}/{$seoproduct}.html'>{$sub['name']}</a></li>
														";
                                                    }
                                                    echo "</ul>";
                                                }
                                            ?>
											</div></div></li></ul></li>	
		  <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fillaments<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li>
					<div class="yamm-content">
						<div class="row">
			  							<?php
                                                $category = $db->select('products','cat =fillaments','','','','','merk','merk ASC');
                                                $count = $db->select('products','','','','rowcount','cat','cat','cat ASC');
                                                $count = ($count == "0")?'1':$count;
                                                $div = ceil(12/$count);
                                                $div = ($div%2 != "0")?$div+1:$div;
                                                foreach ($category as $cat) {
                                                    echo "<ul class='col-md-$div list-unstyled'>";
                                                    $naam = $cat['merk'];
                                                    //echo cats
                                                    echo "
													<li><h4>{$naam}</h4></li>
													<li class='divider'></li>
													";
                                                    $cate = array(":cat" =>$naam);
													$subcat = $db->select('products','cat = :cat AND cat =fillaments','',$cate,'','','','name ASC');
                                                    //echo subcats
                                                    foreach ($subcat as $sub) {
                                                        $seoproduct = str_replace(" ", "-", $sub['name']);
                                                        $seoproduct = strtolower($seoproduct);
                                                        $seomerk = strtolower($sub['merk']);
                                                        echo "
															<li><a href='//{$_SERVER['SERVER_NAME']}/{$seomerk}/{$seoproduct}.html'>{$sub['name']}</a></li>
														";
                                                    }
                                                    echo "</ul>";
                                                }
                                            ?>
											</div></div></li></ul></li>		
											
	            </ul> <!-- Einde NavBar -->
		 	 <ul class="nav navbar-nav navbar-right"> 
	  	  <?php
     if ($perm->check('admin')) {
          ?>			
			<li class="dropdown">
			  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="material-icons">local_play</i> Admin Menu
			  <span class="caret"></span></a>
			  <ul class="dropdown-menu">
					<li><a href="../a/producten"><i class="material-icons">store</i> Producten</a></li>
					 <li><a href="../a/order"><i class="material-icons">history</i> Bestellingen</a></li>
					 <li><a href="../a/promo"><i class='material-icons'>3d_rotation</i> Promoties</a></li> 
					<li class="divider"></li>					
				  <li><a href="../a/gebruikers"><i class="material-icons">account_circle</i> Gebruikers</a></li>
				  <li><a href="../a/groepen"><i class="material-icons">group</i> Groepen</a></li>
				  <li class="divider"></li>
				  <li><a href="../a/versie"><i class="material-icons">verified_user</i> Versie Controle</a></li>
			  </ul>
		  </li>
			  <?php
      }
        if ($perm->check('user')) { //gebruikers
          ?> 			
						<li class="dropdown">
		  				 <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="material-icons">more_vert</i> General
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
						 <li><a href="../history"><i class="material-icons">history</i> Order History</a></li>
						 <li><a href="../clouds"><i class='material-icons'>3d_rotation</i>3D Points</a></li> 
						 <li><a href="../bonus"><i class="material-icons">add_shopping_cart</i>3D Points Shop</a></li> 
						</ul>
						</li>
						<li class="dropdown">
		  				 <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="material-icons">person</i><?php echo $_SESSION['naam'] ?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
						 <li><a href="../profiel"><i class="material-icons">account_circle</i> Profile</a></li>
						 <li><a href="../pass"><i class="material-icons">vpn_key</i> Password</a></li>
						 <li><a href="../logout"><i class="material-icons">exit_to_app</i>Log Out</a></li>  
						</ul>
						</li>

				  <li>
				  <?php
				  	$rand = $session->get('rand');
				  	$bestel = array(":rand" =>$rand);
				  	$total = $db->select('bestelling','bestel = :rand AND status = 0','',$bestel,'rowcount');
					?>
				<a class="badge" data-toggle="modal" data-target="#modal" id="<?php echo $rand ?>" onclick="shopcart(this.id,'shop');" aria-hidden="true"><i class="material-icons">shopping_cart</i><?php echo $total ?></a>
					</li>	
		<?php
        } else { //einde gebruikers
        ?>
		<li>
			 <a href='../login'><i class="material-icons">account_circle</i> Login</a>
		</li>
		<?php
        }
        ?>	 	
			 </ul>
      </div>          
    </div>
  </nav>
<?php
	echo "<div class='error'></div>";
?>        