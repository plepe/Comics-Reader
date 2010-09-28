<?
# Calvin and Hobbes
$calvinandhobbes_name="Calvin and Hobbes";
$calvinandhobbes_url="http://www.gocomics.com/calvinandhobbes/%Y/%m/%d/";

function calvinandhobbes_check($date) {
  $gfx=null;

  $f=fopen("http://www.gocomics.com/calvinandhobbes/".date_ftime($date, "%Y/%m/%d/"), "r");
  while($r=fgets($f)) {
    if(eregi("src=\"http://imgsrv.gocomics.com/dim/\?fh=([0-9a-z\.]*)\"", $r, $m)) {
      if($m[1]) {
        $gfx="http://imgsrv.gocomics.com/dim/?fh=$m[1]";
      }
    }
  }
  fclose($f);

  return $gfx;
}
