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
*          File Name        > <!#FN> bonus.php </#FN>                                                                  
*          File Birth       > <!#FB> 2021/09/18 00:38:17.364 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/24 00:08:07.991 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/

$session = new Session;
$db = new Db;
$perm = new Gebruikers;
?>
<style>
.collapsible {
    background-color: #777;
    color: white;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: center;
    outline: none;
    font-size: 15px;
}

.active,
.collapsible:hover {
    background-color: #555;
}

.content {
    padding: 0 18px;
    display: none;
    overflow: hidden;
    background-color: #f1f1f1;
}
</style>
<div class="container">
    <div class='alert alert-success text-center'>
        <p>for each &euro; spend do you get exactly 1 <i class='material-icons'>3d_rotation</i></i><br />
            This <i class='material-icons'>3d_rotation</i>can you trade for free products in our <i
                class='material-icons'>3d_rotation</i> shop.<br />
            if you get a certain amount of <i class='material-icons'>3d_rotation</i> then you get even extra bonus <i
                class='material-icons'>3d_rotation</i><br />
            Promotions are not fixed, they are for limited time only and will expire at certain dates.</p>
    </div>
    <?php
    if ($perm->check('user')) {
    ?>
    <div class="table-responsive">
        <?php
            $buser = array(':id' => $session->get('id'));
            $result = $db->select('gebruikers', 'id = :id', '', $buser, 'fetch', 'punten');
            $punt = $result['punten'];
            echo "<div class='alert alert-warning text-center'>You have  {$punt} <i class='material-icons'>3d_rotation</i> in total!</div>";
            ?>
        <div class="collapsible">Show Bonus <i class='material-icons'>3d_rotation</i> rank</div>
        <div class="content">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bonus <i class='material-icons'>3d_rotation</i></th>
                        <th>Minimum <i class='material-icons'>3d_rotation</i> needed</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Bonus <i class='material-icons'>3d_rotation</i></th>
                        <th>Minimum <i class='material-icons'>3d_rotation</i> needed</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        $promos = $db->select('discount');
                        $bdis = array(':punt' => $punt);
                        $pun = $db->select('discount', 'clouds <= :punt', '1', $bdis, 'fetch', '*', '', 'clouds DESC');
                        $table2 = "";
                        foreach ($promos as $info) {
                            $id = $info['id'];
                            $puntje = $pun['id'];
                            $promo = ($id == $puntje) ? "<td class=success >$info[discount] &#37;</td><td class=success >$info[clouds] <i class='material-icons'>3d_rotation</i></td>" : "<td class=danger >$info[discount] &#37;</td><td class=danger >$info[clouds] <i class='material-icons'>3d_rotation</i></td>";
                            $table2 .= "<tr>";
                            $table2 .=  "$promo";
                            $table2 .=  "</tr>";
                        }
                        echo $table2;
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="collapsible">Show Our current products that you can buy with <i class='material-icons'>3d_rotation</i>
    </div>
    <div class="content">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style='width:25%'>Name</th>
                    <th style='width:25%'>Brand</th>
                    <th style='width:25%'><i class='material-icons'>3d_rotation</i> points needed</th>
                    <th style='width:25%'>Expires</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style='width:25%'>Name</th>
                    <th style='width:25%'>Brand</th>
                    <th style='width:25%'><i class='material-icons'>3d_rotation</i> points needed</th>
                    <th style='width:25%'>Expires</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $bonus = $db->select('bonus', '', '', '', '', '*', '', 'datum DESC');
                $table = "";
                foreach ($bonus as $info) {
                    $verval = ($info['datum'] < time()) ? "Expired" : date('d-m-Y', $info['datum']);
                    $bbon = array(':id' => $info['pid']);
                    $order = $db->select('products', 'id = :id', '', $bbon, 'fetch');
                    $seoproduct = str_replace(" ", "-", $order['name']);
                    $seoproduct = strtolower($seoproduct);
                    $seomerk = strtolower($order['merk']);
                    $discount = "
												<td style='width:25%' class='info'> <a href='../$seomerk/$seoproduct.html'>$order[name]</a></td>
												<td style='width:25%' class='info'><a href='../$seomerk.html'>$order[merk]</a></td>
												<td style='width:25%' class='warning'>$info[prijs] <i class='material-icons'>3d_rotation</i></td>
												<td style='width:25%' class='danger'>$verval</td>";
                    $table .= "<tr>";
                    $table .=  "$discount";
                    $table .=  "</tr>";
                }
                echo $table;
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
}
</script>