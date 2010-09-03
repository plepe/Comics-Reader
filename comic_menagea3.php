<?
# Menagea3
$gfx=null;
if(!$gfx=get_comic("menagea3", $date)) {
  $dt=new DateTime($date);
  $link_date=$dt->format('Ymd');
  if(@fopen($gfx="http://www.menagea3.net/comics/mat$link_date.png", "r"))
    set_comic("menagea3", $date, $gfx);
  else
    $gfx=null;
}
show_comic("menagea3", "M&eacute;nage &agrave; 3", "http://www.menagea3.net", $gfx);



