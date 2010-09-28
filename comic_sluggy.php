<?
# Sluggy Freelance
$sluggy_name="Sluggy Freelance";
$sluggy_url="http://www.sluggy.com";

function sluggy_check($date) {
  $gfx=null;

  $f=fopen("http://www.sluggy.com/daily.php?date=".date_ftime($date, "%y%m%d"), "r");
  while($r=fgets($f)) {
    if(eregi("<img src=\"http://www.sluggy.com/images/comics/([0-9a-z\.]*)\" alt=\"([0-9a-z\.]*)\">", $r, $m)) {
      if($m[1]==$m[2]) {
        if(substr($m[1], 0, 6)==date_ftime($date, "%y%m%d"))
          $gfx="http://www.sluggy.com/images/comics/$m[1]";
      }
    }
  }
  fclose($f);

  return $gfx;
}
