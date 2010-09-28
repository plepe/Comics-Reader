<?
# Userfriendly
$uf_name="User Friendly";
$uf_url="http://www.userfriendly.org";

function uf_check($date) {
  $gfx=null;

  $f=fopen(sprintf("http://ars.userfriendly.org/cartoons/?id=%s&mode=classic", date_ftime($date, "%Y%m%d")), "r");
  while($r=fgets($f)) {
    if(eregi("<img border=\"0\" src=\"http://www\.userfriendly\.org/cartoons/archives/([0-9]{2}[a-z]{3}/uf[0-9]*\.gif)\" ", $r, $m)) {
      $gfx=$m[1];
    }
  }

  if($gfx)
    $gfx=sprintf("http://www.userfriendly.org/cartoons/archives/%s", $gfx);

  return $gfx;
}
