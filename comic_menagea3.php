<?
# Menagea3
$menagea3_name="Ménage à 3";
$menagea3_url="http://www.menagea3.net";

function menagea3_check($date) {
  $gfx=null;

  $dt=new DateTime($date);
  $link_date=$dt->format('Ymd');
  if(!@fopen($gfx="http://www.menagea3.net/comics/mat$link_date.png", "r"))
    $gfx=null;

  return $gfx;
}
