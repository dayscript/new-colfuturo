<?php
/**
 * @file
 * Contains \Drupal\migrate_d6_metatag_custom\Plugin\migrate\process\Nodewords.
 */
namespace Drupal\migrate_colfuturo\Plugin\migrate\process;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\Component\Utility\Unicode;
/**
 * This plugin converts D6 Nodewords to D8 Metatags.
 *
 * @MigrateProcessPlugin(
 *   id = "colfuturo_images"
 * )
 */


class ColfuturoImages extends ProcessPluginBase {
  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n" .
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36\r\n" . 
        "Referer: http://colombia.travel\r\n"
      )
    );
    $path = $value;
    $http_uri = str_replace(' ','%20',$this->configuration['domain'] . $value);
    var_dump($http_uri);
    $data = file_get_contents( $http_uri, false, stream_context_create($opts));
    $status_line = $http_response_header[0];
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = $match[1];
    if($status == '200'){
      if(  strpos($data, 'noindex,nofollow') === false ){
        $name_file = explode('/', $http_uri);

        $file = $this->saveFile($data,end($name_file));
        return $file;  
      }
    }
  }

  public function getPathDestiny($file_name){
    return $this->configuration['file_destiny']. '/'. $file_name;
  }

  public function saveFile($contents, $file_name){
    return file_save_data($contents, $this->getPathDestiny($file_name), FILE_EXISTS_REPLACE);
  }
}