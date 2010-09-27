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

    if(!$res=sqlite_query($this->linkid, $query, SQLITE_ASSOC, &$error)) {
      echo $error;
      exit;
    }

    return $res;
  }

  function __construct($sqlite_data) {
    global $design_hidden;

    $this->data=$sqlite_data;

    if($design_hidden)
      $this->data[debug]=0;

    $init_necessary=0;
    if((!file_exists($this->data['file']))||(filesize($this->data['file'])==0)) {
      $init_necessary=1;
    }

    if(!$this->linkid=sqlite_open($this->data['file'])) {
      echo "Fehler beim Verbindungsaufbau!<br>";
      exit;
    }

    if($init_necessary) {
      sqlite_exec($this->linkid, file_get_contents("init.sql"));
    }

    return 1;
  }

  function fetch_assoc($res) {
    return sqlite_fetch_array($res, SQLITE_ASSOC);
  }

  function fetch($res) {
    return sqlite_fetch_array($res, SQLITE_ASSOC);
  }

  function num_rows($res) {
    return sqlite_num_rows($res);
  }

  function insert_id() {
    return sqlite_last_insert_rowid($this->linkid);
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
