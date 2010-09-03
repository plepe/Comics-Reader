<?
# Calvin and Hobbes
$gfx=null;
if(!$gfx=get_comic("calvinandhobbes", $date)) {
  $f=fopen("http://www.gocomics.com/calvinandhobbes/".date_ftime($date, "%Y/%m/%d/"), "r");
  while($r=fgets($f)) {
    if(eregi("src=\"http://imgsrv.gocomics.com/dim/\?fh=([0-9a-z\.]*)\"", $r, $m)) {
      if($m[1]) {
        $gfx="http://imgsrv.gocomics.com/dim/?fh=$m[1]";
      }
    }
  }
  fclose($f);

  if($gfx)
    set_comic("calvinandhobbes", $date, $gfx);
}
show_comic("calvinandhobbes", "Calvin and Hobbes", "http://www.gocomics.com/calvinandhobbes/".date_ftime($date, "%Y/%m/%d/"), $gfx);


