<?
# Garfield
$garfield_name="Garfield";
$garfield_url="http://www.garfield.com";

function garfield_check($date) {
  $gfx=null;

  $gfx=sprintf("http://images.ucomics.com/comics/ga/%s/ga%s.gif", date_ftime($date, "%Y"), date_ftime($date, "%y%m%d"));
  if(!@fopen($gfx, "r"))
    $gfx=null;

  return $gfx;
}
