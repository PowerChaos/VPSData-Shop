<?php 
$perm = new Gebruikers;
$session = new Session;
if ($perm->check('user'))
{
  if ($_POST['info'] == 'pass')
  {
    $old    = $_POST['oldpass']??"";
    $new    = $_POST['newpass']??"";
    $check  = $_POST['newpass2']??"";
    $perm->ChangePass($old,$new,$check);
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
}
else
{
$session->flashdata('error','Please login to use this page');
}
?>