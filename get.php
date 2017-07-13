<?php

class GetGeoJson {

  private $place;

  public function __construct()
  {
    $this->place = $_GET['place'];

    $this->solrRequest($this->loadGeo($this->place));
  }

  /**
   * Get polyline shape of place
   * param string $place
   * return json object
   */
  private function loadGeo($place)
  {
    return file_get_contents('places/poly_line_json/' . $place . '.json');
  }

  /**
   * Solr request
   */
  private function solrRequest($geo)
  {
    $gArr = json_decode($geo,true);

    $pol = $gArr['poly'];

    // create curl resource 
    $ch = curl_init(); 

    $base = "http://localhost:8984/solr/stats/select?";

    $param = 'q=*:*&wt=json&rows=1000&fq=location_rpt_two_geo:"Intersects(POLYGON(('.$pol.')))"';

    $ch = curl_init();

    $url = $base.$param;

    $url = str_replace(' ', '+', $url);

    // echo $url;

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);

    $server_output = curl_exec ($ch);
    $info = curl_getinfo($ch);

    $countArr = json_decode($server_output,true);
    $count = $countArr['response']['numFound'];

    curl_close ($ch);   

    $this->formatResponse($countArr);
  }

  /**
   * Format geoJson response
   */
  private function formatResponse($response)
  {

    $data = $response['response']['docs'];

    $arr = [];

    $arr['type'] = 'FeatureCollection';

    foreach($data as $key => $val) {

      $arr['features'][] = [
        'type' => 'Feature',
        'properties' => [
          'nid' => $val['id'],
          'title' => $val['title_en'],
          'field_map_icon' => 'item',
          'description' => $val['title_en']
        ],
        'geometry' => [
          'type' => 'Point',
          'coordinates' => [
            (float)$val['location_1_coordinate'],
            (float)$val['location_0_coordinate']
          ]
        ]
      ];

    }

    echo json_encode($arr,JSON_PRETTY_PRINT);

  }

}

(new GetGeoJson());