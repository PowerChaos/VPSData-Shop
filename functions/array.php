<?php
// Nodig voor Groep
function arr($string, $separator = ',')
{
  //Explode on comma
  $vals = explode($separator, $string);
 
  //Trim whitespace
  foreach($vals as $key => $val) {
    $vals[$key] = trim($val);
  }
  //Return empty array if no items found
  //http://php.net/manual/en/function.explode.php#114273
  return array_diff($vals, array(""));
}

function has_dupes($array){ //dublicate check
 $dupe_array = array();
 foreach($array as $val){
  if(++$dupe_array[$val] > 1){
   return true;
  }
 }
 return false;
}

function dh($time)
{
    $hms = explode(":", $time);
    return ($hms[0] + ($hms[1]/60) + ($hms[2]/3600));
}

function totalhours($start,$end)
{ // total check
$startval = decimalHours(array_values($start)[0]); 
$endval = decimalHours(array_pop((array_slice($end, -1))));

	if ($startval > $endval)
	{
		$endval = $endval + 24;
	}

$totval = $endval - $startval;
return $totval;
}


function followup($start,$end)
{ //follow up check
$dif = array_diff($start,$end);
$tel = count($dif);
return $tel;
}
?>