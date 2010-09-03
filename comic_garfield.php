<?
# Garfield
$gfx=null;
if(!$gfx=get_comic("garfield", $date)) {
  $gfx=sprintf("http://images.ucomics.com/comics/ga/%s/ga%s.gif", date_ftime($date, "%Y"), date_ftime($date, "%y%m%d"));
  if(@fopen($gfx, "r"))
    set_comic("garfield", $date, $gfx);
  else
    $gfx=null;
}
show_comic("garfield", "Garfield", "http://www.garfield.com", $gfx);


