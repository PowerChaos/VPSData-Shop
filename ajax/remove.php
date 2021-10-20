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
*          File Name        > <!#FN> remove.php </#FN>                                                                 
*          File Birth       > <!#FB> 2021/09/18 00:38:17.349 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/10/02 00:45:31.830 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$db = new Db;
$session = new Session;
$id = $_POST['id'] ?? "";
$img = array(':id' => $id);
$confirm = $_POST['confirm'] ?? "";
$waarde = $_POST['waarde'] ?? "";
function RemoveEmptySubFolders($path)
{
    $empty = true;
    foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
        $empty &= is_dir($file) && RemoveEmptySubFolders($file);
    }
    return $empty && rmdir($path);
}

switch ($confirm) {
    case "image":
        $imgcheck = $db->select('images', 'id=:id', '', $img, 'fetch');
        $base = basename($imgcheck['img']);
        $folder = $imgcheck['pid'];
        $target_dir = getenv("DOCUMENT_ROOT") . "/upload/$folder/";
        unlink($target_dir . $base);
        RemoveEmptySubFolders($target_dir);
        $db->delete('images', 'id=:id', $img);
        $session->flashdata('error', 'Afbeelding ' . $id . ' successvol verwijderd');
        break;
    case "product":
        $db->delete('stock', 'pid=:id', $img);
        $db->delete('products', 'id=:id', $img);
        $db->delete('bestelling', 'pid=:id', $img);
        $db->delete('images', 'pid=:id', $img);
        $db->delete('rating', 'pid=:id', $img);
        $session->flashdata('error', 'Product ' . $id . ' successvol verwijderd');
        break;
    case "rating":
        $db->delete('rating', 'pid=:id', $img);
        $session->flashdata('error', 'Product ' . $id . ' rating reset succesfull');
        break;
    case "stock":
        $db->delete('stock', 'id=:id', $img);
        $session->flashdata('error', 'stock  ' . $id . ' succesvol verwijderd');
        break;
    case "shopcart":
        $db->delete('bestelling', 'id=:id', $img);
        $session->flashdata('error', 'Product id ' . $id . ' is succesfull removed from shopping cart');
        break;
    case "promo":
        $db->delete('bonus', 'id=:id', $img);
        $session->flashdata('error', 'promo  ' . $id . ' succesvol verwijderd');
        break;
    case "bonus":
        $db->delete('discount', 'id=:id', $img);
        $session->flashdata('error', 'bonus  ' . $id . ' succesvol verwijderd');
        break;
}
?>
<script>
function werkbij(val, dat) {
    $.ajax({
        type: "POST",
        url: "../x/remove",
        data: 'confirm=' + dat + '&id=' + val,
        success: function(data) {
            //alert(dat+" Succesvol uitgevoerd");
            window.location.reload();
        }
    });
}
</script>
<?php
switch ($_POST['groep']) {
    case "image":
?>
<table border=1 class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <center>verwijder Afbeelding <font color='red'>id <?php echo $waarde; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="delete" id="<?php echo $waarde; ?>"
                        onclick="werkbij(this.id,'image');"><i class='material-icons' title='verwijder'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">verwijder</span></button>
                </center>
            </td>
        </tr>
    </tbody>
</table>
<br>
<?php
        break;
    case "product":
    ?>
<table border=1 class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <center>verwijder Product <font color='red'>id <?php echo $waarde; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <?php if ($_POST['waarde'] != "1") {
                        ?>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="delete" id="<?php echo $waarde; ?>"
                        onclick="werkbij(this.id,'product');"><i class='material-icons' title='verwijder'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">verwijder</span></button>
                </center>
                <?php
                        } else {
                            echo "<center>Not possible to delete first product, it give database errors</center>";
                        }
                        ?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<?php
        break;
    case "rating":
    ?>
<table border=1 class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <center>Reset Rating van Product ID <font color='red'>id <?php echo $waarde; ?>
                    </font> naar 0
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $waarde; ?>"
                        onclick="werkbij(this.id,'rating');"><i class='material-icons' title='Reset'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center>
            </td>
        </tr>
    </tbody>
</table>
<br>
<?php
        break;
    case "stock":
    ?>
<table border=1 class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <center>Bevestig verwijdering van stock <font color='red'>id
                        <?php echo $waarde; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $waarde; ?>"
                        onclick="werkbij(this.id,'stock');"><i class='material-icons' title='Reset'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center>
            </td>
        </tr>
    </tbody>
</table>
<br>
<?php
        break;
    case 'promo':
    ?>
<table border=1 class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <center>Bevestig verwijdering van promo <font color='red'>id
                        <?php echo $waarde; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $waarde; ?>"
                        onclick="werkbij(this.id,'promo');"><i class='material-icons' title='Reset'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center>
            </td>
        </tr>
    </tbody>
</table>
<br>
<?php
        break;
    case 'bonus':
    ?>
<table border=1 class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <center>Bevestig verwijdering van bonus <font color='red'>id
                        <?php echo $waarde; ?></font>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class='info'>
            <td>
                <center><button TYPE="submit" class='btn btn-danger' VALUE="Reset" id="<?php echo $waarde; ?>"
                        onclick="werkbij(this.id,'bonus');"><i class='material-icons' title='Reset'
                            aria-hidden='true'>delete_forever</i><span class="sr-only">Reset</span></button></center>
            </td>
        </tr>
    </tbody>
</table>
<br>
<?php
        break;
}
?>