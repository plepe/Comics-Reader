<?
# Sinfest
$gfx=null;
if(!$gfx=get_comic("sinfest", $date)) {
  if(!@fopen($gfx="http://www.sinfest.net/comikaze/comics/$date.gif", "r"))
    $gfx=null;

  set_comic("sinfest", $date, $gfx);
}
show_comic("sinfest", "Sinfest", "http://www.sinfest.net", $gfx);


