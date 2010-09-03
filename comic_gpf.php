<?
# GPF Comics
$gfx=null;
if(!$gfx=get_comic("gpf", $date)) {
  @$f=fopen("http://www.gpf-comics.com/d/".date_ftime($date, "%Y%m%d").".html", "r");
  if($f) {
    while($r=fgets($f)) {
      if(eregi("<IMG ALT=\"\" BORDER=0 SRC=\"/comics/([a-z0-9\.]*)\".*><BR>", $r, $m)) {
        $gfx="http://www.gpf-comics.com/comics/$m[1]";
        set_comic("gpf", $date, $gfx);
      }
    }
    fclose($f);
  }
  else $gfx=null;
}
show_comic("gpf", "GPF-Comics", "http://www.gpf-comics.com", $gfx);


