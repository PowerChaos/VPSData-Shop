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
*          File Name        > <!#FN> gebruikers.php </#FN>                                                             
*          File Birth       > <!#FB> 2021/09/18 00:38:17.362 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/25 00:29:03.889 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$db = new db;
$perm = new Gebruikers;
if ($perm->check('admin')) {
    $puser = $_POST['users'] ?? "";
    if ($puser) {
        $users = new Gebruikers;
        switch ($puser) {
            case 'rechten': //Rechten aanpassen
                $users->ChangeRechten($_POST['id'], $_POST['rechten']);
                break;
            case 'hernoem': //Naam aanpassen
                $users->ChangeName($_POST['id'], $_POST['naam']);
                break;
            case 'wachtwoord': //wachtwoord aanpassen
                $users->ChangePass('', $_POST['wachtwoord'], '', $_POST['id']);
                break;
            case 'toevoegen': //Gebruiker toevoegen
                $users->AddUser($_POST['wachtwoord'], $_POST['naam']);
                break;
        }
    }
?>
<script type="text/javascript" class="init">
function bewerk(val, dat) {
    $.ajax({
        type: "POST",
        url: "../x/users",
        data: 'groep=' + dat + '&waarde=' + val,
        success: function(data) {
            //alert(data);
            //alert ("del: " +dat+ " en waarde: " +val);
            $("#modal").modal('show');
            $("#modalcode").html(data);
            $('#modal').on('hidden.bs.modal', function() {
                window.location.reload();
            })

        }
    });
}
</script>
<button type="button" class="btn-lg btn-primary text-center" data-toggle="modal" data-target="#modal" id="users"
    onclick="bewerk(this.id,'toevoegen');"><i class="material-icons" title="Gebruiker Toevoegen"
        aria-hidden="true">person_add</i><span class="sr-only">Gebruiker Toevoegen</span></button>
<div class="dropdown pull-right">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Legende
        <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><i class='material-icons'>star</i> Admin</li>
        <li><i class='material-icons'>star_half</i> Staff</li>
        <li><i class='material-icons'>star_border</i> Gebruiker</li>
        <li><i class='material-icons'>not_interested</i> Geblokeerd</li>
    </ul>
</div>
<br><br>
<table border=1 id='groep' class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td>UID</td>
            <td>Naam</td>
            <td>Rechten</td>
            <td>Actie</td>
        </tr>
    </thead>
    <tbody>
        <?php
            $result = $db->select("gebruikers");
            foreach ($result as $info) {
                echo "<tr><td class=warning >$info[id]</td>";
                echo "<td class=success>$info[naam]</td>";
                $groep = $info['rechten'];
                $ban = 'n';
                switch ($groep) {
                    case "3":
                        $groep = "<td class=success><i class='material-icons' title='Admin' aria-hidden='true'>star</i><span class='sr-only'>Admin</span></td>";
                        break;
                    case "2":
                        $groep = "<td class=warning><i class='material-icons' title='Staff' aria-hidden='true'>star_half</i><span class='sr-only'>Staff</span></td>";
                        break;
                    case "b":
                        $groep = "<td class=danger><i class='material-icons' title='Geblokeerd' aria-hidden='true'>not_interested</i><span class='sr-only'>Geblokeerd</span></td>";
                        $ban = 'y';
                        break;
                    default:
                        $groep = "<td class=info><i class='material-icons' title='Gebruiker' aria-hidden='true'>star_border</i><span class='sr-only'>Gebruiker</span></td>";
                }
                echo "$groep";
                echo "<td class=active>";
            ?>
        <div class="dropdown pull-right">
            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Bewerk</button>
            <ul class="dropdown-menu">
                <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                        onclick='bewerk(this.id,"wachtwoord");'><i class='material-icons' title='wachtwoord'
                            aria-hidden='true'>vpn_key</i> Wachtwoord<span class='sr-only'>Wachtwoord</span>
                <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                        onclick='bewerk(this.id,"rechten");'><i class='material-icons' title='Rechten'
                            aria-hidden='true'>group</i> Rechten<span class='sr-only'>Rechten</span>
                <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                        onclick='bewerk(this.id,"hernoem");'><i class='material-icons' title='Naam'
                            aria-hidden='true'>person</i> Naam<span class='sr-only'>Naam</span>
                        <?php if ($ban == 'n') { ?>
                <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                        onclick='bewerk(this.id,"blokeer");'><i class='material-icons' title='Blokeer'
                            aria-hidden='true'>lock</i> Blokeer<span class='sr-only'>Blokeer</span>
                        <?php } else { ?>
                <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                        onclick='bewerk(this.id,"deblokeer");'><i class='material-icons' title='DeBlokeer'
                            aria-hidden='true'>lock_open</i> DeBlokeer<span class='sr-only'>deBlokeer</span>
                        <?php } ?>
                <li><a href='#' data-toggle='modal' data-target='#modal' id='<?php echo $info['id']; ?>'
                        onclick='bewerk(this.id,"verwijder");'><i class='material-icons' title='verwijder'
                            aria-hidden='true'>cancel</i> Verwijder<span class='sr-only'>verwijder</span>
            </ul>
        </div>
        </td>
        <?php
            }
            echo "</tbody></table>";
        }
        ?>