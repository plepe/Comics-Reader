<?
$d=new DOMDocument();
$d->loadXML(file_get_contents("http://feeds.feedburner.com/Explosm"));
$list=$d->getElementsByTagName("item");
for($i=0; $i<$list->length; $i++) {
  $el=$list->item($i);

  $l=$el->getElementsByTagName("guid");
  $link=$l->item(0)->nodeValue;
  print "$link\n";

  $h=file_get_contents($link);
  $imgs=preg_split("/img src=\"([^\"]+)\"/", $h, PREG_SPLIT_DELIM_CAPTURE);
  for($j=0; $j<sizeof($imgs); $j+=2) {
    print $imgs[$j];
  }
}
