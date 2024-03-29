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
*          File Mod         > <!#FT> 2021/10/24 03:18:23.760 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.1.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/






$db = new Db;
$limit = new Limit;
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
            <p>Are you looking for some fillaments? or just browsing to see what we offer ?<br>We got all your need to
                get you started<br>From fillaments to resin and even bulk orders.</p>
        </div>
    </div>
</div>
<!---->
<div class="bride-grids">
    <div class="container">
        <!-- start rows -->
        <?php
        $check = array();
        $c = 0;
        for ($i = 0; $i < 6; $i++) {
            $product = $db->select('products', '', '', '', 'fetch', '*', '', 'RAND()');
            $prod = array('product' => $product['id']);
            $image = $db->select('images', 'pid = :product', '1', $prod, '', '*', '', 'RAND()');
            if (in_array($product['id'], $check)) {
                $i--;
                $c++;
                if ($c >= '20') {
                    $i++;
                    $sp = strtolower(str_replace(" ", "-", $product['name']));
                    $sm = strtolower(str_replace(" ", "-", $product['merk']));
                    if ($i % 2 == 0) {
        ?>
        <div class="col-md-4 bride-grid">
            <div class="content-grid l-grids">
                <!-- row 1-->
                <figure class="effect-bubba">
                    <a href="<?php echo '../' . $sm . '/' . $sp; ?>.html">
                        <img src="<?php echo $image[0]['img'] ?? $defimg ?>" height="320"
                            alt="<?php echo $product['name'] ?>" loading="lazy" />
                        <figcaption>
                            <h4><?php echo $product['merk'] ?></h4>
                            <p><?php echo $product['name'] ?></p>
                            <p><?php echo $limit->set_limit($product['info']); ?></p>
                        </figcaption>
                    </a>
                </figure>
                <div class="clearfix"></div>
                <h3><?php echo $product['cat'] ?></h3>
            </div>
            <?php
                    } else {
                        ?>
            <div class="content-grid l-grids">
                <!-- row 1-->
                <figure class="effect-bubba">
                    <a href="<?php echo '../' . $sm . '/' . $sp; ?>.html">
                        <img src="<?php echo $image[0]['img'] ?? $defimg ?>" height="320"
                            alt="<?php echo $product['name'] ?>" loading="lazy" />
                        <figcaption>
                            <h4><?php echo $product['merk'] ?></h4>
                            <p><?php echo $product['name'] ?></p>
                            <p><?php echo $limit->set_limit($product['info']); ?></p>
                        </figcaption>
                    </a>
                </figure>
                <div class="clearfix"></div>
                <h3><?php echo $product['cat'] ?></h3>
            </div>
        </div>
        <?php
                    }
                }
            } else {
                $sp = strtolower(str_replace(" ", "-", $product['name']));
                $sm = strtolower(str_replace(" ", "-", $product['merk']));
                if ($i % 2 == 0) {
                    ?>
        <div class="col-md-4 bride-grid">
            <div class="content-grid l-grids">
                <!-- row 1-->
                <figure class="effect-bubba">
                    <a href="<?php echo '../' . $sm . '/' . $sp; ?>.html">
                        <img src="<?php echo $image[0]['img'] ?? $defimg ?>" height="320"
                            alt="<?php echo $product['name'] ?>" loading="lazy" />
                        <figcaption>
                            <h4><?php echo $product['merk'] ?></h4>
                            <p><?php echo $product['name'] ?></p>
                            <p><?php echo $limit->set_limit($product['info']); ?></p>
                        </figcaption>
                    </a>
                </figure>
                <div class="clearfix"></div>
                <h3><?php echo $product['cat'] ?></h3>
            </div>
            <?php
                } else {
                    ?>
            <div class="content-grid l-grids">
                <!-- row 1-->
                <figure class="effect-bubba">
                    <a href="<?php echo '../' . $sm . '/' . $sp; ?>.html">
                        <img src="<?php echo $image[0]['img'] ?? $defimg ?>" height="320"
                            alt="<?php echo $product['name'] ?>" loading="lazy" />
                        <figcaption>
                            <h4><?php echo $product['merk'] ?></h4>
                            <p><?php echo $product['name'] ?></p>
                            <p><?php echo $limit->set_limit($product['info']); ?></p>
                        </figcaption>
                    </a>
                </figure>
                <div class="clearfix"></div>
                <h3><?php echo $product['cat'] ?></h3>
            </div>
        </div>
        <?php
                }
                $check[] = $product['id'];
            }
        }
        ?>
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
                $img = $db->select('images', 'pid = :pid', '1', $sel, '', '*', '', 'RAND()');
                $seoproduct = str_replace(" ", "-", strtolower($related['name']));
                $seomerk =  str_replace(" ", "-", strtolower($related['merk']));
            ?>
            <a href="<?php echo '../' . $seomerk . '/' . $seoproduct; ?>.html">
                <div class="product-grid love-grid">
                    <div class="more-product"><span> </span></div>
                    <div class="product-img b-link-stripe b-animate-go  thickbox">
                        <img src="<?php echo $img[0]['img'] ?? $defimg ?>" height="280"
                            alt="<?php echo $related['name'] ?>" loading="lazy" />
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
                <h3>DHL Delivery</h3>
                <p>We only deliver to europe<br><a href='#' data-toggle="modal" data-target="#modal" id="contact"
                        onclick="tos(this.id);" aria-hidden="true">Contact us</a> for other country's</p>
            </div>
            <div class="col-md-4 shpng-grid">
                <h3>Quality Service</h3>
                <p>Great quality for Great price<br>We also use them ourself<br><a href='#' data-toggle="modal"
                        data-target="#modal" id="contact" onclick="tos(this.id);" aria-hidden="true">Contact us</a> for
                    bulk orders</p>
            </div>
            <div class="col-md-4 shpng-grid">
                <h3>Payments</h3>
                <p>Paypal, Cash, Wire Transfer or Bitcoin<br>Other payments possible in our
                    billing system</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>