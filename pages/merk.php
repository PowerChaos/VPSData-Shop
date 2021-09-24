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
*          File Name        > <!#FN> merk.php </#FN>                                                                   
*          File Birth       > <!#FB> 2021/09/18 00:38:17.366 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/22 02:12:22.866 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/




$defimg = Config::DEFIMG;
$db = new Db;
$session = new Session;
if (isset($_GET['merk'])) {
	$id = $_GET['merk'];
	$bmerk = array(':id' => $id);
	$row = $db->select('products', 'merk = :id', '', $bmerk, '', '*', 'cat', 'cat');
	if ($row) {
?>
<div class="welcome">
    <div class="container">
        <div class="col-md-3 welcome-left">
            <h2><?php echo $id ?></h2>
        </div>
        <div class="col-md-9 welcome-right">
            <h3>Here you can find all products back from <?php echo $id ?></h3>
        </div>
    </div>
</div>
<div class="product-model">
    <div class="container">
        <div class="col-md-12 product-model-sec">
            <?php
					foreach ($row as $cat) {
						$bcat = array(':cat' => $cat['cat'], ':merk' => $cat['merk']);
						$check = $db->select('products', 'cat = :cat AND merk = :merk', '', $bmerk, '', '*', '', 'RAND()');
						echo "
						<div class='clearfix'> </div>
			<div class='welcome'>
	 <div class='container'>
		 <div class='col-md-3 welcome-left'>
			 <h2>Category</h2>
		 </div>
		 <div class='col-md-9 welcome-right'>
			 <h3>$cat[cat]</h3>
		 </div>
	 </div>
</div>
<div class='clearfix'> </div>
";

						foreach ($check as $prod) {
							$seoproduct = str_replace(" ", "-", $prod['name']);
							$seoproduct = strtolower($seoproduct);
							$seomerk = strtolower($prod['merk']);
							$bpid = array(':pid' => $prod['id']);
							$rating = $db->select('rating', 'pid = :pid', '', $bpid);
							$ratingcount = $db->select('rating', 'pid = :pid', '', $bpid, 'rowcount');
							$img = $db->select('images', 'pid = :pid', '1', $bpid, '', '*', '', 'RAND()');
							$starcount = "0";
							$totstar = "0";
							foreach ($rating as $star) {
								$starcount += $star['rating'];
							}
							$totstar = ($ratingcount > '0') ? ($starcount / $ratingcount) : "0";
					?>
            <a href="//<?php echo $_SERVER['SERVER_NAME'] . '/' . $seomerk . '/' . $seoproduct; ?>.html">
                <div class="product-grid love-grid">
                    <div class="more-product"><span> </span></div>
                    <div class="product-img b-link-stripe b-animate-go  thickbox">
                        <img src="<?php echo $img['img'] ?? $defimg ?>" height="280"
                            alt="<?php echo $prod['name'] ?>" />
                    </div>
                    <div class="product-info">
                        <div class="product-info-cust prt_name">
                            <h4><?php echo $prod['name'] ?></h4>
                            <input id="stars" name="stars" class="rating rating-loading"
                                value="<?php echo round($totstar, 1) ?>" data-min="0" data-max="5" data-step="1"
                                data-size="md" data-show-clear="false" data-readonly="true" data-show-caption="false">
                            <p>( <?php echo $ratingcount ?> Votes )</p></input>
                        </div>
                    </div>
                </div>
            </a>
            <?php
						}
					}
					?>

        </div>
    </div>
</div>
<?php
	} else {
		$session->flashdata('error', 'Brand not found , please choose the right brand');
	}
}
?>