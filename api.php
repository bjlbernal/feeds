<?php
class FeedsApi
{

  public function __construct(){

  }

  protected function convertToJson($string){
    $string = str_replace(array("\n", "\r", "\t"), '', $string);
    $string = trim(str_replace('"', "'", $string));
    $string = simplexml_load_string($string);
    return json_encode($string);
  }

  public function fetch($params){
    $feed = null;
//debug($params);
    if(isset($params['source'])){
      $handle = fopen($params['source'], "rb");
      $feed = stream_get_contents($handle);
      fclose($handle);
    }
    else echo 'A source is required.';
//debug($feed);
    $feed = new SimpleXmlElement($feed);
    if(isset($params['limit']) and $params['limit'] > 0){
      // Not possible in SimpleXmlElement objects
    }
//debug($feed); exit;
    if(isset($params['raw']) and $params['raw'] === true){
      echo $feed->asXml();
    }

    if(isset($params['convert']) and $params['convert'] == 'json'){
      $feed = $this->convertToJson($feed->asXml());
    }
//debug($feed);
    echo $feed;
  }
}
