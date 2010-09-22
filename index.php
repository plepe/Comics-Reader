<?
require_once("conf.php");
require_once("inc/date.php");
require_once("inc/sql.php");
require_once("functions.php");
$sql=new sql($mysql_data);

$date=$_REQUEST["date"];
if(!$date)
  $date=date_get_today();

$date_exp=explode("-", $date);
$date_month_abbr=array(1=>"jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");

?>
<html>
<head>
<title>Comics for <?=$date?></title>
<link rel="stylesheet" href="comics.css" type="text/css">
<link rel="alternate" type="application/rss+xml" title="Daily Comics RSS" href="rss.php" />
</head>
<body>
<?
function prev_next_links($id=0) {
  global $date;

  print "<a href='?date=".date_add($date, -1).($id?"#$id":"")."'>previous</a>\n";
  print "$date\n";
  print "<a href='?date=".date_add($date,  1).($id?"#$id":"")."'>next</a>\n";
}

function show_comic($id, $name, $url, $gfx) {
  print "<div class='entry'><a name='$id'><h1><a href='$url'>$name</a></h1>\n";
  prev_next_links($id);
  print "<br>\n";
  if(!$gfx)
    print "<span class='comic'>no comic there (yet)</div>";
  else
    print "<img class='comic' src='$gfx' alt='no comic there (yet)'><br>\n";
  print "</div>\n";
}

prev_next_links();

foreach($comic_list as $comic) {
  include("comic_{$comic}.php");
}

### END ###
prev_next_links();
?>
<p>Get the code at <a href='http://gitorious.org/comics-reader'>gitorious.org/comics-reader</a>.
</body>
</html>
