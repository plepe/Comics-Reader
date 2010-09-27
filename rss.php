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

function show_comic($id, $name, $url, $gfx) {
  global $date;

  if($gfx&&($gfx!=1)) {
    print "  <item>\n";
    print "    <title>$name - $date</title>\n";
    print "    <link>$url</link>\n";

    print "    <description><![CDATA[<img src=\"$gfx\">]]></description>\n";
    $d=date_ftime("%a, %d %b %Y %H:%M:%S +0200", $date);
    print "    <pubDate>$d</pubDate>\n";
    print "    <guid isPermaLink=\"false\">$date @ $id</guid>\n";
    print "  </item>\n";
  }
}

$today=date_get_today();
for($i=-$rss_days; $i<=0; $i++) {
  $date=date_add($today, $i);
  foreach($comic_list as $comic) {
    include("comic_{$comic}.php");
  }
}

print "</channel>\n";
print "</rss>\n";
