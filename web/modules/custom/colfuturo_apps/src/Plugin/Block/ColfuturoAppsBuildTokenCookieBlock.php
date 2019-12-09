<?php

namespace Drupal\colfuturo_apps\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Cookie;



/**
 * Provides a 'ColfuturoAppsBuildTokenCookieBlock' block.
 *
 * @Block(
 *  id = "colfuturo_apps_build_token_cookie_block",
 *  admin_label = @Translation("Colfuturo apps build token cookie block"),
 * )
 */
class ColfuturoAppsBuildTokenCookieBlock extends BlockBase {


  protected $is_token;



  public function __construct(){
    $this->is_token = false;
    // $this->SetTokenCognito();

  }
  /**
   * {@inheritdoc}
   */
  public function build() {

    $session = \Drupal::request()->getSession();
    $miniorange_congito_oauth2 = json_decode($session->get('miniorange_congito_oauth2'), true);

    $build = [];
    $build['colfuturo_apps_build_token_cookie_block']['#markup'] = 'Implement ColfuturoAppsBuildTokenCookieBlock.';
    $build['#cache'] = [
      'max-age' => 0,
    ];
    

    if($this->is_token || 0 == 0){
      $build['#attached'] = array(
        'library' => array('colfuturo_apps/colfuturo_apps'),
        'drupalSettings'  => [
            'colfuturo_apps' => [
              'colftuturo_apps_cognito' => $miniorange_congito_oauth2['IdToken'],
              'item_class' => '.colfu-app-clic'
              ]
            ]
      );
    }else{
      drupal_set_message('Se ha detectado una operacion ilegal, por favor contacte al administrador del sitio.', 'error');
    }
    return $build;
  }


  // public function SetTokenCognito(){
  //     user_cookie_save(
  //       [ 
  //       'drupal-session-cognito' => $_SESSION['access_token_cognito']['IdToken'] 
  //       ] 
  //     );
  //     $this->is_token =  true;
  //   }
  

}
