<?
# GPF Comics
$gpf_name="GPF-Comics";
$gpf_url="http://www.gpf-comics.com";

function gpf_check($date) {
  $gfx=null;

  @$f=fopen("http://www.gpf-comics.com/d/".date_ftime($date, "%Y%m%d").".html", "r");
  if($f) {
    while($r=fgets($f)) {
      if(eregi("<IMG ALT=\"\" BORDER=0 SRC=\"/comics/([a-z0-9\.]*)\".*><BR>", $r, $m)) {
        $gfx="http://www.gpf-comics.com/comics/$m[1]";
      }
    }
    fclose($f);
  }

  return $gfx;
}
