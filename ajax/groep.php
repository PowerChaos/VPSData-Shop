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
*          File Name        > <!#FN> groep.php </#FN>                                                                  
*          File Birth       > <!#FB> 2021/09/18 00:38:17.346 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/25 00:28:59.147 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/



$db = new Db;
$groep = new Groepen;
$waarde = $_POST['waarde'] ?? "";
$gebruiker = $_POST['groep'] ?? "";
$del = $_POST['del'] ?? "";
if (!empty($waarde)) {
    switch ($del) {
        case 'delete': { ?>
<form action="../a/groepen" method="POST" class='text-center'>
    <input type="hidden" name="groep" value="delgroep">
    <input type="hidden" name="id" value="<?php echo $waarde ?>">
    <input type="submit" value="Bevestig Verwijdering van groep <?php echo $waarde ?>" class="btn btn-danger">
</form>
<?php
                break;
            }
        case 'eigenaars': {
            ?>
<form action="../a/groepen" method="POST" class='text-center'>
    <input type="hidden" name="groep" value="deleigenaar">
    <input type="hidden" name="groepnaam" value="<?php echo $gebruiker ?>">
    <input type="hidden" name="id" value="<?php echo $waarde ?>">
    <input type="submit"
        value="Bevestig Verwijdering eigenaar <?php echo $waarde ?> uit groep id <?php echo $gebruiker ?>"
        class="btn btn-danger">
</form>
<?php
                break;
            }
        case 'gebruikers': {
            ?>
<form action="../a/groepen" method="POST" class='text-center'>
    <input type="hidden" name="groep" value="delgebruiker">
    <input type="hidden" name="groepnaam" value="<?php echo $gebruiker ?>">
    <input type="hidden" name="id" value="<?php echo $waarde ?>">
    <input type="submit"
        value="Bevestig Verwijdering gebruiker <?php echo $waarde ?> uit groep id <?php echo $gebruiker ?>"
        class="btn btn-danger">
</form>
<?php
                break;
            }
    }
    if ($gebruiker == 'gebruikers') {
        $account = $db->select("gebruikers", "rechten !='b'");
        ?>
<SCRIPT language="javascript">
function addRow(tableID) {

    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;

    for (var i = 0; i < colCount; i++) {

        var newcell = row.insertCell(i);

        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch (newcell.childNodes[0].type) {
            case "text":
                newcell.childNodes[0].value = "";
                break;
            case "checkbox":
                newcell.childNodes[0].checked = false;
                break;
            case "select-one":
                newcell.childNodes[0].selectedIndex = 0;
                break;
        }
    }
}
</SCRIPT>
<p class='text-center'>
    <input type="button" class="btn btn-danger" value="Voeg meer personen toe" onClick="addRow('invoer')" />
</p>
<form action="../a/groepen" method="POST" class='text-center'>
    <input type="hidden" name="groep" value="addgebruikers">
    <input type="hidden" name="gid" value="<?php echo $waarde ?>">
    <table border=1 class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Gebruikers</th>
            </tr>
            <thead>
            <tbody id="invoer">
                <tr>
                    <td>
                        <select class="form-control" name="gebruikers[]" id="gebruikers[]">
                            <?php
                                    foreach ($account as $class) {
                                        echo "<option value='$class[id]'>$class[naam]</option>";
                                    }
                                    ?>
                        </select>
                    </td>
                </tr>
            </tbody>
    </table>
    <input type="submit" value="Voeg Toe" class="btn btn-success text-center">
</form>

<?php
    }
    if ($gebruiker == 'eigenaars') {
        $account = $db->select("gebruikers", "rechten !='b'");

    ?>
<SCRIPT language="javascript">
function addRow(tableID) {

    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;

    for (var i = 0; i < colCount; i++) {

        var newcell = row.insertCell(i);

        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch (newcell.childNodes[0].type) {
            case "text":
                newcell.childNodes[0].value = "";
                break;
            case "checkbox":
                newcell.childNodes[0].checked = false;
                break;
            case "select-one":
                newcell.childNodes[0].selectedIndex = 0;
                break;
        }
    }
}
</SCRIPT>
<p class='text-center'>
    <input type="button" class="btn btn-danger" value="Voeg meer Eigenaars toe" onClick="addRow('invoer')" />
</p>
<form action="../a/groepen" method="POST" class='text-center'>
    <input type="hidden" name="groep" value="addeigenaars">
    <input type="hidden" name="gid" value="<?php echo $waarde ?>">
    <table border=1 class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Eigenaars</th>
            </tr>
            <thead>
            <tbody id="invoer">
                <tr>
                    <td>
                        <select class="form-control" name="gebruikers[]" id="gebruikers[]">
                            <?php
                                    foreach ($account as $class) {
                                        echo "<option value='$class[id]'>$class[naam]</option>";
                                    }
                                    ?>
                        </select>
                    </td>
                </tr>
            </tbody>
    </table>
    <p class="bg-danger text-center">Je kan maar Eigenaar zijn van 1 Groep</p>
    <input type="submit" value="Voeg Eigenaars Toe" class="btn btn-success text-center">
</form>

<?php
    }
    if ($gebruiker == 'toevoegen') {
    ?>
<SCRIPT language="javascript">
function addRow(tableID) {

    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;

    for (var i = 0; i < colCount; i++) {

        var newcell = row.insertCell(i);

        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch (newcell.childNodes[0].type) {
            case "text":
                newcell.childNodes[0].value = "";
                break;
            case "checkbox":
                newcell.childNodes[0].checked = false;
                break;
            case "select-one":
                newcell.childNodes[0].selectedIndex = 0;
                break;
        }
    }
}
</SCRIPT>
<p class='text-center'>
    <input type="button" class="btn btn-danger" value="Voeg meer Groepen toe" onClick="addRow('invoer')" />
</p>
<form action="../a/groepen" method="POST" class='text-center'>
    <input type="hidden" name="groep" value="addgroep">
    <table border=1 class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>GroepNaam</th>
            </tr>
            <thead>
            <tbody id="invoer">
                <tr>
                    <td>
                        <input type="text" class="form-control" name="groepen[]" id="groepen[]">
                    </td>
                </tr>
            </tbody>
    </table>
    <input type="submit" value="Voeg Groep Toe" class="btn btn-success text-center">
</form>
<?php
    }
    if ($gebruiker == 'groepnaam') //eigenaars toevoegen
    {
        $naam = $db->select("groep", "id = $waarde", "", "", "fetch");
    ?>
<form action="../a/groepen" method="POST" class='text-center'>
    <input type="hidden" name="groep" value="groepnaam">
    <input type="hidden" name="waarde" value="<?php echo $waarde ?>">
    <table border=1 class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>GroepNaam</th>
            </tr>
            <thead>
            <tbody id="invoer">
                <tr>
                    <td>
                        <input type="text" class="form-control" name="data" id="data"
                            value="<?php echo $naam['naam'] ?>">
                    </td>
                </tr>
            </tbody>
    </table>
    <input type="submit" value="Verander GroepNaam" class="btn btn-success text-center">
</form>
<?php
    }
}
?>