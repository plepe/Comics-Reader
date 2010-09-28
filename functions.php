<?
// returns either the url to the comic
// or null, to indicate it doesn't know about a comic for this date
// or 1 to indicate it doesn't know, but has checked lately
// ... lately: during last 15 minutes, or during last day, when the comic
// is more than two days old it checks max. once a week. After two months a
// comic is considered missing
function get_comic($comic, $date) {
  global $sql;

  $res=$sql->query("select gfx, strftime('%s', 'now')-strftime('%s', timestamp) as last from comics_date where comic='$comic' and date='$date'");
  if($elem=$sql->fetch_assoc($res)) {
    if($elem['gfx'])
      return $elem["gfx"];
    elseif(!date_is_after($date, date_add(date_get_today(), -60))) {
      return null;
    }
    elseif((!date_is_after($date, date_add(date_get_today(), -2)))&&($elem['last']>24*60*60))
      return null;
    elseif($elem['last']>60)
      return null;
    else
      return 1;
  }

  return null;
}

function set_comic($comic, $date, $gfx) {
  global $sql;

  if($gfx!==1)
    $sql->query("insert or replace into comics_date values ('$comic', '$date', \"$gfx\", datetime('now'))");

  return 1;
}


