<?
# Userfriendly
$gfx=null;
if(!$gfx=get_comic("uf", $date)) {
  $f=fopen(sprintf("http://ars.userfriendly.org/cartoons/?id=%s&mode=classic", date_ftime($date, "%Y%m%d")), "r");
  while($r=fgets($f)) {
    if(eregi("<img border=\"0\" src=\"http://www\.userfriendly\.org/cartoons/archives/([0-9]{2}[a-z]{3}/uf[0-9]*\.gif)\" ", $r, $m)) {
      $gfx=$m[1];
    }
  }

  if($gfx)
    $gfx=sprintf("http://www.userfriendly.org/cartoons/archives/%s", $gfx);

  set_comic("uf", $date, $gfx);
}
show_comic("uf", "User Friendly", "http://www.userfriendly.org", $gfx);


