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
*          File Name        > <!#FN> product.php </#FN>                                                                
*          File Birth       > <!#FB> 2021/09/18 00:38:17.367 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/22 01:16:09.929 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/


$defimg = Config::DEFIMG;
$session = new Session;
$db = new DB;
if (isset($_GET['product'])) {
    $id = str_replace("-", " ", $_GET['product']);
    $bid = array(':id' => $id);
    $prod = $db->select('products', 'name = :id', '', $bid, 'fetch');
    $bpid = array(':pid' => $prod['id']);
    $rating = $db->select('rating', 'pid = :pid', '', $bpid);
    $ratingcount = $db->select('rating', 'pid = :pid', '', $bpid, 'rowcount');
    $img = $db->select('images', 'pid = :pid', '', $bpid, '', '*', '', 'RAND()');
    $starcount = "0";
    $totstar = "0";
    foreach ($rating as $star) {
        $starcount += $star['rating'];
    }
    $totstar = ($ratingcount > '0') ? ($starcount / $ratingcount) : "0";

    //stock Weergave
    $amount = $db->select('stock', 'pid = :pid', '', $bpid, '', '*', '', 'naam');
    //sort($amount);
    //Cloud Shop
    $btid = array(':pid' => $prod['id'], ':tm' => time());
    $clknop = $db->select('bonus', 'pid = :pid AND datum > :tm', '', $btid, 'fetch');
    if ($session->get('id') != "") {
        $ubind = array(':uid' => $session->get('id'));
        $getuser = $db->select('gebruikers', 'id = :uid', '', $ubind, 'fetch');
        $dbind = array(':clouds' => $getuser['punten']);
        $disc = $db->select('discount', 'clouds <= :clouds', '1', $dbind, '', '*', '', 'clouds DESC');
        $korting = floor($prod['prijs']);
        $discount = $disc[0]['discount'];
        $bonus = ($korting / 100) * $discount;
        $clouds = " <div class='clearfix'></div> <li class='active'>earn <clouds id='clouds'>" . $korting . "</clouds> <i class='material-icons'>3d_rotation</i></li>";
        $tot = floor($korting + $bonus);
        $totbonus = "<li>+ <d id='disc'>$discount</d> % Bonus =  <t id='bon'>$tot</t> <i class='material-icons'>3d_rotation</i></li><div class='clearfix'></div>";
    }
    if ($prod) {
?>
<div class="single-sec">
    <div class="container">
        <!-- start content -->
        <div class="col-md-9 det">
            <div class="single_left">
                <div class="flexslider">
                    <ul class="slides">
                        <?php
                                if (!$img) { ?>
                        <li data-thumb="<?php echo $defimg ?>">
                            <img src="<?php echo $defimg ?>" />
                        </li>
                        <?php } else {
                                    foreach ($img as $image) { ?>
                        <li data-thumb="<?php echo $image['img'] ?? $defimg ?>">
                            <img src="<?php echo $image['img'] ?? $defimg ?>" />
                        </li>
                        <?php }
                                } ?>
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
                <h3><?php echo $prod['name'] ?></h3>
                <div class="id">
                    <h4>Category: <?php echo $prod['cat'] ?></h4>
                </div>
                <?php $sk = strtolower($prod['merk']); ?>
                <div class="id">
                    <h4>Brand: <a href="<?php echo "../" . $sk ?>.html"><?php echo $prod['merk'] ?></a>
                    </h4>
                </div>
                <form action="" class="sky-form">
                    <fieldset>
                        <section>
                            <div class="id">
                                <div class="rating">
                                    <h4><input id="star-rating-value" value="<?php echo round($totstar) ?>"
                                            type="number">( <?php echo $ratingcount ?> Votes )</input></h4>
                                    <!-- <input id="star-rating" name="star-rating" class="rating rating-loading" value="<?php echo $prod['rating'] ?>" data-min="0" data-max="5" data-step="1">  -->
                                </div>
                            </div>
                        </section>
                    </fieldset>
                </form>
                <div class="cost">
                    <?php
                            echo "Select Color : <select id='kleur' name='kleur'>";
                            foreach ($amount as $stok) {
                                echo "<option value='$stok[naam]'>$stok[naam]</option>";
                            }
                            ?>
                    </select>
                    <div class='clearfix'></div><br>
                    Select amount :<aantal id='aantal'></aantal><br><br>
                    <div class="clearfix"></div>
                    <div class="prdt-cost">
                        <ul>
                            <?php echo $clouds ?>
                            <div class="clearfix"></div>
                            <?php echo $totbonus;
                                    $prijs = $clknop['prijs'] ?? ""; ?>
                            <input type="hidden" value="<?php echo $prod['prijs'] ?>" id='check'>
                            <input type="hidden" value="<?php echo $prijs ?>" id='clcheck'>
                            <button type="button" class="btn-lg btn-primary text-center kleur" data-toggle="modal"
                                data-target="#modal" id="<?php echo $prod['id'] ?>"
                                onclick="shop(this.id,'toevoegen')">Buy now for &euro; <prijs id='prijs'>
                                    <?php echo $prod['prijs'] ?></prijs>
                                <?php if ($prijs) { ?>
                                or <free id='free'><?php echo $prijs ?></free> <i class='material-icons'>3d_rotation</i>
                                <?php } ?>
                            </button>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="single-bottom1">
                    <h6>Product Description</h6>
                    <p class="prod-desc"><?php echo $prod['over'] ?></p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="featured">
    <div class="container">
        <h3>Our Selection <?php echo $prod['cat'] ?></h3>
        <div class="feature-grids">
            <!-- Random producten -->
            <?php
                    $brel = array(':cat' => $prod['cat']);
                    $rel2 = $db->select('products', 'cat = :cat', '3', $brel, '', '*', '', 'RAND()');
                    foreach ($rel2 as $related2) {
                        $bim = array(':pid' => $related2['id']);
                        $img = $db->select('images', 'pid = :pid', '1', $bim, '', '*', '', 'RAND()');
                        $seoproduct = str_replace(" ", "-", $related2['name']);
                        $seoproduct = strtolower($seoproduct);
                        $seomerk = strtolower($related2['merk']);
                    ?>
            <a href="<?php echo '../' . $seomerk . '/' . $seoproduct; ?>.html">
                <div class="product-grid love-grid">
                    <div class="more-product"><span> </span></div>
                    <div class="product-img b-link-stripe b-animate-go  thickbox">
                        <img src="<?php echo $img[0]['img'] ?? $defimg ?>" height="280"
                            alt="<?php echo $related2['name'] ?>" />
                    </div>
                    <div class="product-info">
                        <div class="product-info-cust prt_name">
                            <h4><?php echo $related2['merk'] . " <br> " . $related2['name'] ?></h4>
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
<script type="text/javascript">
$(document).ready(function() {
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
        var prod = "<?php echo $prod['id'] ?>";
        $.ajax({
            type: "POST",
            url: "../x/voting",
            data: 'rating=' + dat + '&prod=' + prod,
            success: function(data) {
                //alert(data);
                //alert ("dat " +dat+ "prod"+prod);
                $("#modal").modal('show');
                $("#modalcode").html(data);
            }
        });
    }); //einde rating

    //Select Update
    $("#aantal").load("../x/stock", {
        kleur: "geen",
        prod: "<?php echo $prod['id'] ?>",
    });
    $('#kleur').on('change', function() { //begin Rating Waarde
        var dat = $('#kleur').val();
        $.ajax({
            type: "POST",
            url: "../x/stock",
            data: 'kleur=' + dat,
            success: function(data) {
                //alert(data);
                //alert ("item: " +dat+ " en waarde: " +val+ "en kleur : "+kleur+" en qty : "+qty);
                $('#aantal').html(data);
            }
        });


    });

}); //einde document Ready		
//Shop Toevoegen
function shop(val, dat) {
    var qty = $("#qty").val();
    var kleur = $("#kleur").val();
    $.ajax({
        type: "POST",
        url: "../x/shop",
        data: 'item=' + dat + '&waarde=' + val + '&kleur=' + kleur + '&qty=' + qty,
        success: function(data) {
            //alert(data);
            //alert ("item: " +dat+ " en waarde: " +val+ "en kleur : "+kleur+" en qty : "+qty);
            $("#modal").modal('show');
            $("#modalcode").html(data);
            $('#modal').on('hidden.bs.modal', function() {
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
<?php
    } else {
        $session->flashdata('error', 'Product not found, please check product link');
    }
}
?>