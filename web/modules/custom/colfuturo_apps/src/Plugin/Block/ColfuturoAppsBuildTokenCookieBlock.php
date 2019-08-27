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

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['colfuturo_apps_build_token_cookie_block']['#markup'] = 'Implement ColfuturoAppsBuildTokenCookieBlock.';
    $build['#cache'] = [
      'max-age' => 0,
    ];
    $response = new Response();
    $cookie = new Cookie('drupal-session-cognito',$_SESSION['access_token_cognito']);
    $response->headers->setCookie($cookie);
    return $build;
  }

}
