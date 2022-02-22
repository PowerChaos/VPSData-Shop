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
*          File Mod         > <!#FT> 2021/10/24 03:25:38.556 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.1.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/

$db = new Db;
$perm = new Gebruikers;
$session = new Session;
$divider = '6';
?>
<!-- fixed top navbar -->
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigatie"
                aria-expanded="false" aria-controls="navigatie">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="../home"> <img src="../img/header.png" alt="VPS Data - Webshop" id="logo">
            </a>
            <!-- <a class="navbar-brand" href="../home"><b>Vaporama - World of Vaping</b></a> -->
        </div>
        <!--navbar menu options: shown on desktop only -->
        <div class="navbar-collapse collapse" id="navigatie">
            <ul class="nav yamm navbar-nav">
                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">category<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="yamm-content">
                                <div class="row">
                                    <?php
                                    $category = $db->select('products', '', '', '', '', 'cat', 'cat', 'cat ASC');
                                    $count = $db->select('products', '', '', '', 'rowcount', 'cat', 'cat', 'cat ASC');
                                    $count = $count ?? '1';
                                    if ($count <= $divider) {
                                        $div = ceil($divider / $count);
                                    } else {
                                        $div = $divider;
                                    }
                                    $new = '1';
                                    foreach ($category as $cat) {
                                        if ($new % $divider == 0) {
                                            echo "<div class='row'>";
                                        }
                                        echo "<ul class='col-md-$div list-unstyled'>";
                                        $naam = $cat['cat'];
                                        //echo cats
                                        echo "
													<li><h4>$naam</h4></li>
													<li class='divider'></li>
													";
                                        //echo subcats
                                        //subcats query en count
                                        $cate = array(":cat" => $naam);
                                        $subcat = $db->select('products', 'cat = :cat', '', $cate, '', '*', 'merk', 'merk ASC');
                                        foreach ($subcat as $sub) {
                                            $seomerk = str_replace(" ", "-", strtolower($sub['merk']));
                                            echo "
															<li><a href='../{$seomerk}.html'>{$sub['merk']}</a></li>
														";
                                        }
                                        echo "</ul>";
                                        if ($new % $divider == 0) {
                                            echo "</div>";
                                        }
                                        $new++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products<b class="caret"></b></a>
                    <ul class="dropdown-menu ">
                        <li>
                            <div class="yamm-content">
                                <div class="row">
                                    <?php
                                    $category = $db->select('products', '', '', '', 'fetchall', '*', 'merk', 'cat ASC');
                                    $count = $db->select('products', '', '', '', 'rowcount', 'cat', 'merk', 'cat ASC');
                                    $count = $count ?? '1';
                                    if ($count <= $divider) {
                                        $div = ceil($divider / $count);
                                    } else {
                                        $div = "12";
                                    }
                                    $new = '1';
                                    foreach ($category as $cat) {
                                        if ($new % $divider == 0) {
                                            echo "<div class='row'>";
                                        }
                                        echo "<ul class='col-md-$div list-unstyled'>";
                                        $naam = $cat['merk'];
                                        //echo cats
                                        echo "
                                                                                        <li><h4>$naam</h4></li>
                                                                                        <li class='divider'></li>
                                                                                        ";
                                        //echo subcats
                                        //subcats query en count
                                        $cate = array(":cat" => $naam);
                                        $subcat = $db->select('products', 'merk = :cat', '', $cate, 'fetchall', '*', '', 'merk ASC');
                                        foreach ($subcat as $sub) {
                                            $seoproduct = str_replace(" ", "-", strtolower($sub['name']));
                                            $seomerk = str_replace(" ", "-", strtolower($sub['merk']));
                                            echo "
															<li><a href='../{$seomerk}/{$seoproduct}.html'>{$sub['name']}</a></li>
														";
                                        }
                                        echo "</ul>";
                                        if ($new % $divider == 0) {
                                            echo "</div>";
                                        }
                                        $new++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- //bondtech -->
                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">BondTech<b class="caret"></b></a>
                    <ul class="dropdown-menu ">
                        <li>
                            <div class="yamm-content">
                                <div class="row">
                                    <?php
                                    $bond = array(":cat" => 'BondTech');
                                    $category = $db->select('products', 'merk = :cat', '', $bond, 'fetchall', '*', 'cat', 'cat ASC');
                                    $count = $db->select('products', 'merk = :cat', '', $bond, 'rowcount', 'cat', '', 'cat ASC');
                                    $count = $count ?? '1';
                                    if ($count <= $divider) {
                                        $div = ceil($divider / $count);
                                    } else {
                                        $div = "12";
                                    }
                                    $new = '1';
                                    foreach ($category as $cat) {
                                        if ($new % $divider == 0) {
                                            echo "<div class='row'>";
                                        }
                                        echo "<ul class='col-md-$div list-unstyled'>";
                                        $naam = $cat['cat'];
                                        $sorting = array(':cat' => $cat['cat'], ':merk' => $cat['merk']);
                                        //echo cats
                                        echo "
                                                                                        <li><h4>$naam</h4></li>
                                                                                        <li class='divider'></li>
                                                                                        ";
                                        //echo subcats
                                        //subcats query en count
                                        $subcat = $db->select('products', 'cat = :cat && merk = :merk', '', $sorting, 'fetchall', '*', '', 'merk ASC');
                                        foreach ($subcat as $sub) {
                                            $seoproduct = str_replace(" ", "-", strtolower($sub['name']));
                                            $seomerk = str_replace(" ", "-", strtolower($sub['merk']));
                                            echo "
															<li><a href='../{$seomerk}/{$seoproduct}.html'>{$sub['name']}</a></li>
														";
                                        }
                                        echo "</ul>";
                                        if ($new % $divider == 0) {
                                            echo "</div>";
                                        }
                                        $new++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- //BigTricky -->
                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">BigTricky<b class="caret"></b></a>
                    <ul class="dropdown-menu ">
                        <li>
                            <div class="yamm-content">
                                <div class="row">
                                    <?php
                                    $bond = array(":cat" => 'BigTricky');
                                    $category = $db->select('products', 'merk = :cat', '', $bond, 'fetchall', '*', 'cat', 'cat ASC');
                                    $count = $db->select('products', 'merk = :cat', '', $bond, 'rowcount', 'cat', '', 'cat ASC');
                                    $count = $count ?? '1';
                                    if ($count <= $divider) {
                                        $div = ceil($divider / $count);
                                    } else {
                                        $div = "12";
                                    }
                                    $new = '1';
                                    foreach ($category as $cat) {
                                        if ($new % $divider == 0) {
                                            echo "<div class='row'>";
                                        }
                                        echo "<ul class='col-md-$div list-unstyled'>";
                                        $naam = $cat['cat'];
                                        $sorting = array(':cat' => $cat['cat'], ':merk' => $cat['merk']);
                                        //echo cats
                                        echo "
                                                                                        <li><h4>$naam</h4></li>
                                                                                        <li class='divider'></li>
                                                                                        ";
                                        //echo subcats
                                        //subcats query en count
                                        $subcat = $db->select('products', 'cat = :cat && merk = :merk', '', $sorting, 'fetchall', '*', '', 'merk ASC');
                                        foreach ($subcat as $sub) {
                                            $seoproduct = str_replace(" ", "-", strtolower($sub['name']));
                                            $seomerk = str_replace(" ", "-", strtolower($sub['merk']));
                                            echo "
															<li><a href='../{$seomerk}/{$seoproduct}.html'>{$sub['name']}</a></li>
														";
                                        }
                                        echo "</ul>";
                                        if ($new % $divider == 0) {
                                            echo "</div>";
                                        }
                                        $new++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul> <!-- Einde NavBar -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../bonus"><i class='material-icons'>3d_rotation</i> Shop</a></li>
                <?php
                if ($perm->check('admin')) {
                ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="material-icons">local_play</i>
                        Admin Menu
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
                <li><a href="../history"><i class="material-icons">history</i> Order History</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i
                            class="material-icons">person</i><?php echo $_SESSION['naam'] ?>
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
                        $bestel = array(":rand" => $rand);
                        $total = $db->select('bestelling', 'bestel = :rand AND status = 0', '', $bestel);
                        $totalpart = 0;
                        foreach ($total as $qty) {
                            $totalpart += $qty['qty'];
                        }
                        ?>
                    <a class="badge" data-toggle="modal" data-target="#modal" id="<?php echo $rand ?>"
                        onclick="shopcart(this.id,'shop');" aria-hidden="true"><i
                            class="material-icons">shopping_cart</i>
                        <font color='red'><?php echo $totalpart ?></font>
                    </a>
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