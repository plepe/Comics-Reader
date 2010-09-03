<?
$date_sql_unix_get_machine="'%Y-%m-%d %H:%i'";
$date_weekdays_abbr=array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa", "So");
$date_weekdays_full=array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag");
$date_month_full=array(1=>"Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
$date_month_abbr=array(1=>"Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez");

function date_ftime($date, $format) {
  global $date_weekdays_abbr;
  global $date_weekdays_full;
  global $date_month_abbr;
  global $date_month_full;

  $date=date_get_array($date);

  $replace=array(
    "%a"=>$date_weekdays_abbr[date_get_weekday($date)],
    "%A"=>$date_weekdays_full[date_get_weekday($date)],
    "%b"=>$date_month_abbr[$date[1]],
    "%B"=>$date_month_full[$date[1]],
    "%c"=>date_get_human($date),
    "%C"=>substr($date, 0, 2),
    "%d"=>sprintf("%02d", $date[2]),
    "%D"=>"$date[1]/$date[2]/$date[0]",
    "%e"=>(int)$date[2],
#   "%g"=>
#   "%G"=>
    "%h"=>$date_month_abbr[$date[1]],
    "%H"=>$date[3],
    "%I"=>sprintf("%02d", $date[3]%12==0?12:$date[3]%12),
#   "%j"=
    "%m"=>sprintf("%02d", $date[1]),
    "%M"=>$date[4],
    "%n"=>"\n",
    "%p"=>($date[3]<12?"am":"pm"),
#   "%r"=>
#   "%R"=>
    "%S"=>0,
    "%t"=>"\t",
    "%T"=>sprintf("%d:%02d:%02d", $date[3], $date[4], 0),
    "%u"=>(($x=date_get_weekday($date))==0?7:$x),
#   "%U"=>
#   "%V"=>
#   "%W"=>
    "%w"=>date_get_weekday($date),
    "%x"=>date_get_human($date, 0),
    "%X"=>sprintf("%d:%02d:%02d", $date[3], $date[4], 0),
    "%y"=>substr($date[0], 2, 2),
    "%Y"=>$date[0],
    "%Z"=>"MEZ",
    "%%"=>"%"
  );

  return strtr($format, $replace);
}

// mode: 0..auto, 1..without time, 2..with time, 3..convert to without time
function date_get_human($date, $base=0, $mode=0) {
  $date=date_get_array($date, $base, $mode);
  if(!$date)
    return $date;

  if(sizeof($date)==3)
    return sprintf("%d.%d.%d", $date[2], $date[1], $date[0]);
  else
    return sprintf("%d.%d.%d %d:%02d", $date[2], $date[1], $date[0], $date[3], $date[4]);
}

function date_get_machine($date, $base=0, $mode=0) {
  $date=date_get_array($date, $base, $mode);
  if(!$date)
    return $date;

  if(sizeof($date)==3)
    return sprintf("%04d-%02d-%02d", $date[0], $date[1], $date[2]);
  else
    return sprintf("%04d-%02d-%02d %02d:%02d", $date[0], $date[1], $date[2], $date[3], $date[4]);
}

function date_get_array($date, $base=0, $mode=0) {
  if(!$date)
    return 0;

  if(is_array($date)) {
    switch($mode) {
      case 0:
        return $date;
      case 1:
        if(sizeof($date)==5)
          return null;
        return $date;
      case 2:
        if(sizeof($date)==3)
          return null;
        return $date;
      case 3:
        return array_slice($date, 0, 3);
    }
  }

  if(eregi("^([0-9][0-9][0-9][0-9])\-([0-9][0-9])\-([0-9][0-9])( ([0-9][0-9]):([0-9][0-9])(:[0-9][0-9])?)?$", $date, $m)) {
    if(($m[4])&&($mode==1))
      return null;
    if((!$m[4])&&($mode==2))
      return null;

    if((!$m[4])||($mode==3))
      return array((int)$m[1], (int)$m[2], (int)$m[3]);
    else
      return array((int)$m[1], (int)$m[2], (int)$m[3], (int)$m[5], (int)$m[6]);
  }

  if(eregi("^([0-9][0-9]?)\.([0-9][0-9]?)\.([0-9][0-9][0-9][0-9]|[0-9][0-9])?( ([0-9]?[0-9]):([0-9][0-9]))?$", $date, $m)) {
    if(($m[4])&&($mode==1))
      return null;
    if((!$m[4])&&($mode==2))
      return null;

    if(!$m[3]) {
      if(!$base)
        $base=date_get_now();
      $base=date_get_last_date($base);
      $base=date_get_array($base);
      //print "BASE ";print_r($base); print "<=";
      $m[3]=$base[0];

      if(!date_is_after(array($m[3], $m[2], $m[1]), $base))
        $m[3]++;
    }
    elseif($m[3]<40) {
      $m[3]="20".$m[3];
    }
    elseif($m[3]<100) {
      $m[3]="19".$m[3];
    }

    if((!$m[4])||($mode==3))
      return array((int)$m[3], (int)$m[2], (int)$m[1]);
    else
      return array((int)$m[3], (int)$m[2], (int)$m[1], (int)$m[5], (int)$m[6]);
  }

  if(eregi("^([0-9][0-9]?):([0-9][0-9])(:[0-9][0-9])?$", $date, $m)) {
    if(($m[4])&&($mode==2))
      return null;

    if(!$base)
      $base=date_get_now();
    $base=date_get_last_date($base);
    $base=date_get_array($base);

    if(($m[1]<$base[3])||(($m[1]==$base[3])&&($m[2]<$base[4]))) {
      $base=date_add($base, 1);
    }

    if($mode==3)
      return array($base[0], $base[1], $base[2]);
    else
      return array($base[0], $base[1], $base[2], (int)$m[1], (int)$m[2]);
  }

  if(is_integer($date)) {
    if(($mode==0)||($mode==2))
      return explode("\t", date("Y\tm\td\tH\ti", $date));
    else
      return explode("\t", date("Y\tm\td", $date));
  }

  return null;
}

function date_get_today() {
  return Date("Y-m-d");
}

function date_get_now() {
  return Date("Y-m-d H:i");
}

function date_is_after($check_date, $date) {
  if(is_array($check_date))
    $check_date=date_get_first_date($check_date);
  if(is_array($date))
    $date=date_get_last_date($check_date);
  
  $check_date=date_get_machine($check_date);
  $date=date_get_machine($date);

  return ($check_date>$date);
}

function date_get_weekday($date) {
  $date=date_get_array($date);
  if(!$date)
    return $date;

  return Date("w", mktime(12, 0, 0, $date[1], $date[2], $date[0], -1));
}

function date_add($date, $diff) {
  $m=false;
  if(is_string($date)) {
    $m=true;
    $date=date_get_array($date);
  }

  if(sizeof($date)==3)
    $n=Date("Y-m-d", mktime(12, 0, 0, $date[1], $date[2], $date[0], -1)+86400*$diff);
  else
    $n=Date("Y-m-d H:i", mktime($date[4], $date[5], 0, $date[1], $date[2], $date[0], -1)+86400*$diff);

  if(!$m)
    return date_get_array($n);

  return $n;
}

function date_get_unix($date) {
  $date=date_get_array($date);
  if(sizeof($date)==3) {
    $date[]=12;
    $date[]=0;
  }

  return mktime($date[3], $date[4], 0, $date[1], $date[2], $date[0], -1);
}

function date_diff($date1, $date2) {
  $d1=date_get_unix($date1);
  $d2=date_get_unix($date2);

  $t=$d2-$d1;
  return sprintf("%02d:%02d", (int)($t/3600), (int)($t%3600/60));
}

function time_get_human($date, $m=0) {
  $date=time_get_array($date, $m);
  if(!$date)
    return $date;

  return sprintf("%2d:%02d", $date[0], $date[1]);
}

function time_get_machine($date, $m=0) {
  $date=time_get_array($date, $m);
  if(!$date)
    return $date;

  return sprintf("%02d:%02d", $date[0], $date[1]);
}

function time_get_array($date, $m=0) {
  if(is_array($date))
    return $date;

  if(!$date)
    return "";

  if(eregi("^([0-9]+):([0-9][0-9])(:[0-9][0-9])?$", $date, $m)) {
    return array((int)$m[1], (int)$m[2]);
  }
  if(eregi("^([0-9]+)[,\.]([0-9])$", $date, $m)) {
    if($m[1]=="5")
      return array((int)$m[1], 30);
    else
      return array((int)$m[1],  0);
  }
  if(eregi("^([0-9]+)$", $date, $m)) {
    return array((int)$m[1], 0);
  }

  return null;
}

function date_get_first_date($dates) {
  if(!$dates)
    return;

  if(is_string($dates))
    return $dates;

  foreach($dates as $d)
    $ndates[]=date_get_machine($d);

  sort($ndates);
  return $ndates[0];
}

function date_get_last_date($dates) {
  if(!$dates)
    return;

  if(is_string($dates))
    return $dates;

  foreach($dates as $d)
    $ndates[]=date_get_machine($d);

  rsort($ndates);
  return $ndates[0];
}
