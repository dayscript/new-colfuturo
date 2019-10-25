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
    
    return [
      'credentials' => [
          'key' => 'AKIAJFTJ4Z7ZMR5I7R6A',
          'secret' => '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',
      ],
      'region' => 'us-west-2',
      'version' => 'latest',
      'app_client_id' => '1c5ulue3iht87j5kuoke7v0dlh',
      'app_client_secret' => '1k50sla85ql8hjecs0re4498plathnbjjipoj8pe53tgpb0furgn',
      'user_pool_id' => 'us-west-2_1d9AhcwHF',
    ];
  
  }


}
