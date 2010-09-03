<?
# Sinfest
$gfx=null;
if(!$gfx=get_comic("sinfest", $date)) {
  if(@fopen($gfx="http://www.sinfest.net/comikaze/comics/$date.gif", "r"))
    set_comic("sinfest", $date, $gfx);
  else
    $gfx=null;
}
show_comic("sinfest", "Sinfest", "http://www.sinfest.net", $gfx);


