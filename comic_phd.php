<?
# Phd Comics
$gfx=null;
if(!$gfx=get_comic("phd", $date)) {
  $gfx=sprintf("http://www.phdcomics.com/comics/archive/phd%ss.gif", date_ftime($date, "%m%d%y"), $num);
  if(@fopen($gfx, "r"))
    set_comic("phd", $date, $gfx);
  else
    $gfx=null;
}
show_comic("phd", "Phd-Comics", "http://www.phdcomics.com", $gfx);


