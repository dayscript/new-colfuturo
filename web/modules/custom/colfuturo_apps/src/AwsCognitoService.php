<?php

namespace Drupal\colfuturo_apps;


/**
 * Class AwsCognitoService.
 */
class AwsCognitoService implements InterfaceAwsCognitoService {



  /**
   * @var string
  */
  protected $config;
  public $client;

  


  /**
   * Constructs a new AwsCognitoService object.
   */
  public function __construct() {

    $this->setConfig();
    
    $aws = new \Aws\Sdk($this->config);
    $cognitoClient = $aws->createCognitoIdentityProvider();

    $this->client = new \pmill\AwsCognito\CognitoClient($cognitoClient);
    $this->client->setAppClientId($this->config['app_client_id']);
    $this->client->setAppClientSecret($this->config['app_client_secret']);
    $this->client->setRegion($this->config['region']);
    $this->client->setUserPoolId($this->config['user_pool_id']);

  }

  /**
   * @param  
   * @param 
   *
   * @return 
   * @throws 
   * @throws 
   */
  public function setConfig()  {
      
    $this->config = self::getConfig();
    
  }

  /**
   * @param  
   * @param 
   *
   * @return array[]
   * @throws 
   * @throws 
   */
  public function getConfig()  {
    

    $config = \Drupal::config('colfuturo_apps_settings_form.settings');

    return [
      'credentials' => [
          'key' => $config->get('amazon_access_key_id'),
          'secret' => $config->get('amazon_secret_access_key'),
      ],
      'region' => $config->get('region'),
      'version' => $config->get('version'),
      'app_client_id' => $config->get('app_client_id'),
      'app_client_secret' => $config->get('app_client_secret'),
      'user_pool_id' => $config->get('user_pool_id'),
    ];
  
  }


}
