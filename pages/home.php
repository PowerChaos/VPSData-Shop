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
*          File Name        > <!#FN> home.php </#FN>                                                                   
*          File Birth       > <!#FB> 2021/09/18 00:38:17.365 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/20 00:46:34.482 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/






$db = new Db;
$defimg = Config::DEFIMG;
?>
<!---->
<img src="../img/3d.png" alt="VPS Data - 3D made easy" class="centerhome">
<!---->
<div class="welcome">
	<div class="container">
		<div class="col-md-3 welcome-left">
			<h2>VPS Data WebShop</h2>
		</div>
		<div class="col-md-9 welcome-right">
			<h3>VPS Data is here for all your needs</h3>
			<p>Are you looking for some fillamnets? or just browsing to see what we offer ?<br>We got all your need to
				get you started<br>From Fillamlents to resin and even bulk orders.</p>
		</div>
	</div>
</div>
<!---->
<?php
//cat Selection
//Category's
$pid1 = $db->select('products', 'cat = Esun', '1', '', '', '*', '', 'RAND()');
$pid2 = $db->select('products', 'cat = Makerfill', '1', '', '', '*', '', 'RAND()');
$pid3 = $db->select('products', 'cat = Fillament', '1', '', '', '*', '', 'RAND()');
$pid4 = $db->select('products', 'cat = Resin', '1', '', '', '*', '', 'RAND()');
$pid5 = $db->select('products', 'cat = Others', '1', '', '', '*', '', 'RAND()');

//images
$img = array(
	':pid1' => $pid1['id'],
	':pid2' => $pid2['id'],
	':pid3' => $pid3['id'],
	':pid4' => $pid4['id'],
	':pid5' => $pid5['id']
);

$imgid1 = $db->select('iamges', 'pid = :pid1', '1', $img, '', '*', '', 'RAND()');
$imgid2 = $db->select('iamges', 'pid = :pid2', '1', $img, '', '*', '', 'RAND()');
$imgid3 = $db->select('iamges', 'pid = :pid3', '1', $img, '', '*', '', 'RAND()');
$imgid4 = $db->select('iamges', 'pid = :pid4', '1', $img, '', '*', '', 'RAND()');
$imgid5 = $db->select('iamges', 'pid = :pid5', '1', $img, '', '*', '', 'RAND()');

//seo Namen
$sp1 = strtolower(str_replace(" ", "-", $pid1['name']));
$sm1 = strtolower($pid1['merk']);
$sp2 = strtolower(str_replace(" ", "-", $pid2['name']));
$sm2 = strtolower($pid2['merk']);
$sp3 = strtolower(str_replace(" ", "-", $pid3['name']));
$sm3 = strtolower($pid3['merk']);
$sp4 = strtolower(str_replace(" ", "-", $pid4['name']));
$sm4 = strtolower($pid4['merk']);
$sp5 = strtolower(str_replace(" ", "-", $pid5['name']));
$sm5 = strtolower($pid5['merk']);
?>

<div class="bride-grids">
	<div class="container">
		<div class="col-md-4 bride-grid">
			<div class="content-grid l-grids">
				<!-- row 1-->
				<figure class="effect-bubba">
					<a href="//<?php echo $_SERVER['SERVER_NAME'] . '/' . $sm1 . '/' . $sp1; ?>.html">
						<img src="<?php echo ($imgid1['img'] == "") ? $defimg : $imgid1['img'] ?>" height="320" alt="<?php echo $pid1['name'] ?>" />
						<figcaption>
							<h4>Esun</h4>
							<p>Esun is a Premium Quality Fillament </p>
						</figcaption>
					</a>
				</figure>
				<div class="clearfix"></div>
				<h3>Esun</h3>
			</div>
			<div class="content-grid l-grids">
				<!-- row 2-->
				<figure class="effect-bubba">
					<a href="//<?php echo $_SERVER['SERVER_NAME'] . '/' . $sm2 . '/' . $sp2; ?>.html">
						<img src="<?php echo ($imgid2['img'] == "") ? $defimg : $imgid2['img'] ?>" height="320" alt="<?php echo $pid2['name'] ?>" />
						<figcaption>
							<h4>MakerFill</h4>
							<p>Our premium Belguim brand for quality prints</p>
						</figcaption>
					</a>
				</figure>
				<div class="clearfix"></div>
				<h3>MakerFill</h3>
			</div>
		</div>
		<!--einde row 1 en 2 -->
		<div class="col-md-4 bride-grid">
			<!-- row 3-->
			<div class="content-grid l-grids">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAP4AAADfCAIAAABZBPmVAAACZklEQVR4nO3SMQEAIAzAMMC/5yFjRxMFPXpn5kDP2w6AHdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaI+Re8Eu6ekYsUAAAAASUVORK5CYII=" height="100" alt="whitespace" />
			</div>
			<div class="content-grid l-grids">
				<figure class="effect-bubba">
					<a href="//<?php echo $_SERVER['SERVER_NAME'] . '/' . $sm3 . '/' . $sp3; ?>.html">
						<img src="<?php echo ($imgid3['img'] == "") ? $defimg : $imgid3['img'] ?>" height="480" alt="<?php echo $pid3['name'] ?>" />
						<figcaption>
							<h4>Fillaments</h4>
							<p>Our premium selection of fillamnets<br>We offer Esun and Makerfill for your FDM
								Printer.<br>The quality is tested and is verified. </p>
						</figcaption>
					</a>
				</figure>
				<div class="clearfix"></div>
				<h3>Fillaments</h3>
			</div>
			<div class="content-grid l-grids">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAP4AAADfCAIAAABZBPmVAAACZklEQVR4nO3SMQEAIAzAMMC/5yFjRxMFPXpn5kDP2w6AHdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaI+Re8Eu6ekYsUAAAAASUVORK5CYII=" height="100" alt="whitespace" />
			</div>
		</div>
		<!--einde row 3 -->
		<div class="col-md-4 bride-grid">
			<div class="content-grid l-grids">
				<!-- row 4-->
				<figure class="effect-bubba">
					<a href="//<?php echo $_SERVER['SERVER_NAME'] . '/' . $sm4 . '/' . $sp4; ?>.html">
						<img src="<?php echo ($imgid4['img'] == "") ? $defimg : $imgid4['img'] ?>" height="320" alt="<?php echo $pid4['name'] ?>" />
						<figcaption>
							<h4>Resin</h4>
							<p>Resin from Esun for quality prints</p>
						</figcaption>
					</a>
				</figure>
				<div class="clearfix"></div>
				<h3>Resin</h3>
			</div>
			<div class="content-grid l-grids">
				<!-- row 5-->
				<figure class="effect-bubba">
					<a href="//<?php echo $_SERVER['SERVER_NAME'] . '/' . $sm5 . '/' . $sp5; ?>.html">
						<img src="<?php echo ($imgid5['img'] == "") ? $defimg : $imgid5['img'] ?>" height="320" alt="<?php echo $pid5['name'] ?>" />
						<figcaption>
							<h4>Others</h4>
							<p>We got a lot of other stuff for you<br>SD cards, Tape, 3D prints ... </p>
						</figcaption>
					</a>
				</figure>
				<div class="clearfix"></div>
				<h3>Others</h3>
			</div>
		</div>
		<!--einde row 4 en 5 -->
		<div class="clearfix"></div>
	</div>
</div>
<!---->

<div class="featured">
	<div class="container">
		<h3>Our random selction of products</h3>
		<div class="feature-grids">
			<!-- Random producten -->
			<?php
			$rel = $db->select('products', '', '3', '', '', '*', '', 'RAND()');
			foreach ($rel as $related) {
				$sel = array(':pid' => $related['id']);
				$select = $db->select('images', 'pid = :pid', '1', $sel, '', '*', '', 'RAND()');
				$seoproduct = str_replace(" ", "-", $related['name']);
				$seoproduct = strtolower($seoproduct);
				$seomerk = strtolower($related['merk']);
			?>
				<a href="//<?php echo $_SERVER['SERVER_NAME'] . '/' . $seomerk . '/' . $seoproduct; ?>.html">
					<div class="product-grid love-grid">
						<div class="more-product"><span> </span></div>
						<div class="product-img b-link-stripe b-animate-go  thickbox">
							<img src="<?php echo ($select['img'] == "") ? $defimg : $select['img'] ?>" height="280" alt="<?php echo $related['name'] ?>" />
						</div>
						<div class="product-info">
							<div class="product-info-cust prt_name">
								<h4><?php echo $related['merk'] . " <br> " . $related['name'] ?></h4>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				</a>
			<?php
			}
			?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!---->

<div class="shoping">
	<div class="container">
		<div class="shpng-grids">
			<div class="col-md-4 shpng-grid">
				<h3>Premium Delivery</h3>
				<p>We deliver up to 30KG<br>PostNL , BPost or DPD</p>
			</div>
			<div class="col-md-4 shpng-grid">
				<h3>Quality Service</h3>
				<p>Our products are of great quality<br>We also use them ourself</p>
			</div>
			<div class="col-md-4 shpng-grid">
				<h3>Payments</h3>
				<p>Easy simple system<br>Paypal of direct orders<br>Other payments possible in our billing system</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>