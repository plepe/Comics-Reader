<?
class sql {
  // public vars
  public $debug;
  // private vars
  private $data;
  private $linkid;

  function query($query) {
    $query=strtr($query, array("%PREFIX%"=>$this->data[prefix]));
    if($this->data[debug])
      print "<!-- SQL-Query: $query -->\n";

    if(!$res=mysql_db_query($this->data[db], $query, $this->linkid)) {
      echo mysql_error();
      exit;
    }

    return $res;
  }

  function __construct($mysql_data) {
    global $design_hidden;

    $this->data=$mysql_data;

    if($design_hidden)
      $this->data[debug]=0;

    if(!$this->linkid=mysql_connect($this->data[host], $this->data[user], $this->data[passwd])) {
      echo "Fehler beim Verbindungsaufbau!<br>";
      exit;
    }

    return 1;
  }

  function fetch_assoc($res) {
    return mysql_fetch_assoc($res);
  }

  function fetch($res) {
    return mysql_fetch_assoc($res);
  }

  function num_rows($res) {
    return mysql_num_rows($res);
  }

  function insert_id() {
    return mysql_insert_id();
  }

  function build_set($data, $exclude=array()) {
    $str=array();
    foreach($data as $k=>$v) {
      if(!in_array($k, $exclude)) {
        if($v)
          $str[]="$k=\"$v\"";
        else
          $str[]="$k=null";
      }
    }

    return $str;
  }
}
