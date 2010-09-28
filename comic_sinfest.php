<?
# Sinfest
$sinfest_name="Sinfest";
$sinfest_url="http://www.sinfest.net";

function sinfest_check($date) {
  $gfx=null;

  if(!@fopen($gfx="http://www.sinfest.net/comikaze/comics/$date.gif", "r"))
    $gfx=null;

  return $gfx;
}
