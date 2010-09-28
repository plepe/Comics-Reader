<?
# Phd Comics
$phd_name="Phd-Comics";
$phd_url="http://www.phdcomics.com";

function phd_check($date) {
  $gfx=null;

  $gfx=sprintf("http://www.phdcomics.com/comics/archive/phd%ss.gif", date_ftime($date, "%m%d%y"), $num);
  if(!@fopen($gfx, "r"))
    $gfx=null;

  return $gfx;
}
