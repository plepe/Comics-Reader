<?
  function sql($query) {
    global $MYSQL_debug;
    global $MYSQL_DB;

    if($MYSQL_debug)
      print "<!-- SQL-Query: $query -->\n";
    if(!$res=mysql_db_query($MYSQL_DB, "$query")) {
      echo mysql_error();
      exit;
    }
    return $res;
  }

  function db_connect() {
    global $MYSQL_host;
    global $MYSQL_user;
    global $MYSQL_password;

    if(!$linkid=mysql_connect($MYSQL_host, $MYSQL_user, $MYSQL_password)) {
      echo "Fehler beim Verbindungsaufbau!<br>";
      exit;
    }
    return $linkid;
  }
?>
