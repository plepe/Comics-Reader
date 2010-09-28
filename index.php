<?
Header("content-type: text/html; charset=utf-8");
require_once("conf.php");
require_once("inc/date.php");
require_once("inc/sql.php");
require_once("functions.php");
$sql=new sql($sqlite_data);

$date=$_REQUEST["date"];
if(!$date)
  $date=date_get_today();

$date_exp=explode("-", $date);
$date_month_abbr=array(1=>"jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");

foreach($comic_list as $comic) {
  include "comic_$comic.php";
}
?>
<html>
<head>
<title>Comics for <?=$date?></title>
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="alternate" type="application/rss+xml" title="Daily Comics RSS" href="rss.php" />
</head>
<body>
<?
function prev_next_links($id=0) {
  global $date;
  $ret="";

  $i=-1;
  if($id) {
    $found=false;
    while(($i>-10)&&(!$found)) {
      if(get_comic($id, date_add($date, $i))) {
        $found=true;
      }
      else
        $i--;
    }
    if(!$found)
      $i=-1;
  }

  $ret.="<a href='?date=".date_add($date, $i).($id?"#$id":"")."'>previous</a>\n";
  $ret.="$date\n";

  $i=1;
  if($id) {
    $found=false;
    while(($i<10)&&(date_add($date, $i)<=date_get_today())&&(!$found)) {
      if(get_comic($id, date_add($date, $i))) {
        $found=true;
      }
      else
        $i++;
    }
    if(!$found)
      $i=1;
  }

  $ret.="<a href='?date=".date_add($date,  $i).($id?"#$id":"")."'>next</a>\n";

  return $ret;
}

function show_comic($id, $date) {
  $ret="";
  $gfx=get_comic($id, $date);
  $name="{$id}_name";
  $url="{$comic}_url";
  global $$name;
  global $$url;

  $ret.="<div class='entry'><a name='$id'><h1><a href='{$$url}'>{$$name}</a></h1>\n";
  $ret.=prev_next_links($id);
  $ret.="<br>\n";
  if(!$gfx)
    $ret.="<span class='comic'>no comic there (yet)</div>";
  else
    $ret.="<img class='comic' src='$gfx' alt='no comic there (yet)'><br>\n";
  $ret.="</div>\n";

  return $ret;
}

print prev_next_links();
print "<br>\n";

foreach($comic_list as $comic) {
  print show_comic($comic, $date);
}

### END ###
print prev_next_links();
?>
<p>Get the code at <a href='http://gitorious.org/comics-reader'>gitorious.org/comics-reader</a>.
</body>
</html>
