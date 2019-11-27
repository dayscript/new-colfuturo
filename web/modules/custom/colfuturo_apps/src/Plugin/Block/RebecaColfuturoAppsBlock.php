<?php

namespace Drupal\colfuturo_apps\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\user\Entity\User;

/**
 * Provides a 'RebecaColfuturoAppsBlock' block.
 *
 * @Block(
 *  id = "rebeca_colfuturo_apps_block",
 *  admin_label = @Translation("Chat Rebeca"),
 * )
 */
class RebecaColfuturoAppsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Routing\CurrentRouteMatch definition.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new RebecaColfuturoAppsBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    CurrentRouteMatch $current_route_match, 
	AccountProxyInterface $current_user
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentRouteMatch = $current_route_match;
    $this->currentUser = $current_user;
  }


   /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }



  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
      $container->get('current_user')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $user = User::load($this->currentUser->id());
    
    $link_rebeca = 'http://rebeca.agenti.com.co/rebeca/?ID='. $this->currentUser->getDisplayName() . '&NAME1=' . $user->field_nombres->value. '&NAME2=""' . '&EMAIL=' . $this->currentUser->getEmail() . '&STATUS=""';
    
    if( in_array('beneficiario_pcb', $this->currentUser->getRoles() ) ){
      $link_rebeca = 'http://rebecapcb.agenti.com.co/rebecapcb/?ID='. $this->currentUser->getDisplayName() . '&NAME1=' . $user->field_nombres->value . '&NAME2=""' . '&EMAIL=' . $this->currentUser->getEmail() . '&STATUS=""';
    }

    $build['#theme'] = 'rebeca_colfuturo_apps_block';
    $build['rebeca_colfuturo_apps_block']['#markup'] = 'Implement RebecaColfuturoAppsBlock.';
    $build['#vars'] = $link_rebeca;

    return $build;
  }

}
