<?
require_once("conf.php");
require_once("inc/date.php");
require_once("inc/sql.php");
require_once("functions.php");
$sql=new sql($sqlite_data);

Header("Content-Type: application/xhtml+xml; charset=utf-8");

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
print "<rss xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\">\n";

print "<channel>\n";
print "  <title>Daily Comics</title>\n";
print "  <link>http://xover.mud.at/~skunk/comics.php</link>\n";
print "  <description>Daily Comics of various Websites.</description>\n";

foreach($comic_list as $comic) {
  include "comic_$comic.php";
}

function show_comic($id, $date) {
  $ret="";
  $gfx=get_comic($id, $date);
  $name="{$id}_name";
  $url="{$comic}_url";
  global $$name;
  global $$url;

  if($gfx&&($gfx!=1)) {
    $ret.="  <item>\n";
    $ret.="    <title>{$$name} - $date</title>\n";
    $ret.="    <link>{$$url}</link>\n";

    $ret.="    <description><![CDATA[<img src=\"$gfx\">]]></description>\n";
    $d=date_ftime("%a, %d %b %Y %H:%M:%S +0200", $date);
    $ret.="    <pubDate>$d</pubDate>\n";
    $ret.="    <guid isPermaLink=\"false\">$date @ $id</guid>\n";
    $ret.="  </item>\n";
  }

  return $ret;
}

$today=date_get_today();
for($i=-$rss_days; $i<=0; $i++) {
  $date=date_add($today, $i);
  foreach($comic_list as $comic) {
    print show_comic($comic, $date);
  }
}

print "</channel>\n";
print "</rss>\n";
