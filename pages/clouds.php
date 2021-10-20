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
*          File Name        > <!#FN> clouds.php </#FN>                                                                 
*          File Birth       > <!#FB> 2021/09/18 00:38:17.364 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/22 02:50:06.854 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$db = new Db;
$session = new Session;
$perm = new Gebruikers;
if ($perm->check('user')) {
?>
<div class="container">
    <div>
        <h4>This page shows you a overview how our point system works</h4>
        <hr />
        <p>for each &euro; spend do you get exactly 1 <i class='material-icons'>3d_rotation</i></i><br />
            This <i class='material-icons'>3d_rotation</i>can you trade for free products in our <a href='../bonus'><i
                    class='material-icons'>3d_rotation</i> shop.</a><br />
            if you get a certain amount of <i class='material-icons'>3d_rotation</i> then you get even extra bonus <i
                class='material-icons'>3d_rotation</i><br />
            Promotions are not fixed, they are for limited time only and will expire at certain dates.</p>
    </div>
    <div class="table-responsive">
        <?php
            $buser = array(':id' => $session->get('id'));
            $result = $db->select('gebruikers', 'id = :id', '', $buser, 'fetch', 'punten');
            $punt = $result['punten'];
            echo "<div class='alert alert-info text-center'>You have  {$punt} <i class='material-icons'>3d_rotation</i> in total!</div>";
            ?>
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
    <?php
} else {
    $session->flashdata('error', 'Please login to use this page');
}