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
*          File Name        > <!#FN> pass.php </#FN>                                                                   
*          File Birth       > <!#FB> 2021/09/18 00:38:17.366 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/24 21:11:38.764 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$perm = new Gebruikers;
$session = new Session;
if ($perm->check('user')) {
  if ($_POST['info'] == 'pass') {
    $old    = $_POST['oldpass'] ?? "";
    $new    = $_POST['newpass'] ?? "";
    $check  = $_POST['newpass2'] ?? "";
    $perm->ChangePass($old, $new, $check);
  }
?>
<div class="container">
    <form action="" method="post" id='pass' name='pass'>
        <input type="hidden" name="info" value="pass" />
        Old Password:<br>
        <input class="form-control" type="text" name="oldpass"><br>
        New Password:<br>
        <input class="form-control" type="password" name="newpass"><br>
        Repeat New Password:<br>
        <input class="form-control" type="password" name="newpass2"><br>
        <input class="btn btn-danger" type="submit" value="Submit">
    </form>
</div>
<?php
} else {
  $session->flashdata('error', 'Please login to use this page');
}
?>