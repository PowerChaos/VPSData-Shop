<?php
function u()
{
if ($_SESSION['loggedin'] == 1)
{
return true;
}
else
{
return false;
}
}

function a()
{
if ($_SESSION['admin'] == 1)
{
return true;
}
else
{
return false;
}
}

function s()
{
if ($_SESSION['admin'] == 1 || $_SESSION['staff'] == 1 )
{
return true;
}
else
{
return false;
}
}
/* CopyRight PowerChaos 2016 */
?>