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
*          File Version     > <!#FV> 0.0.1 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/
   
$db = new Db;
$perm = new Permission;
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
	  <a href="../home"> <img src="data:image/png;base64,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" alt="VPS Data - Webshop">
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
                                                $count = ($count == "")?'1':$count;
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
                                                $count = ($count == "")?'1':$count;
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
                                                $count = ($count == "")?'1':$count;
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
                    $shop = $db->prepare("SELECT * FROM bestelling WHERE bestel ='$_SESSION[rand]' and status = '0'");
                    $shop->execute();
                    $count = $shop->RowCount();
                    $total = ($count == "")?"0":$count;?>
				<a class="badge" data-toggle="modal" data-target="#modal" id="<?php echo $_SESSION['rand'] ?>" onclick="shopcart(this.id,'shop');" aria-hidden="true"><i class="material-icons">shopping_cart</i><?php echo $total ?></a>
					</li>	
		<?php
        } else { //einde gebruikers
        ?>
		<li>
			 <a href='../login'><i class="material-icons">account_circle</i> Login</a>
		</li>
		<li>
			 <a href='#' data-toggle="modal" data-target="#modal" id="register" onclick="login(this.id);" aria-hidden="true" ><i class="material-icons">vpn_key</i> Register</a>
		</li>
		<?php
        }
        ?>	 	
			 </ul>
      </div>          
    </div>
  </nav>
<?php
$session->flash('error');
/*
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}
*/
?>        