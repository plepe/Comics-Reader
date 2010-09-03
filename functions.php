<?
function get_comic($comic, $date) {
  global $sql;

  $res=$sql->query("select gfx from comics_date where comic='$comic' and date='$date'");
  if($elem=$sql->fetch_assoc($res)) {
    return $elem["gfx"];
  }

  if(!date_is_after($date, date_add(date_get_today(), -2))) {
    return 1;
  }

  return null;
}

function set_comic($comic, $date, $gfx) {
  global $sql;

  $sql->query("insert into comics_date set comic='$comic', date='$date', gfx=\"$gfx\"");

  return 1;
}


