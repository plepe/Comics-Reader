<?
# Menagea3
$gfx=null;
if(!$gfx=get_comic("menagea3", $date)) {
  $dt=new DateTime($date);
  $link_date=$dt->format('Ymd');
  if(!@fopen($gfx="http://www.menagea3.net/comics/mat$link_date.png", "r"))
    $gfx=null;

  set_comic("menagea3", $date, $gfx);
}
show_comic("menagea3", "Ménage à 3", "http://www.menagea3.net", $gfx);



