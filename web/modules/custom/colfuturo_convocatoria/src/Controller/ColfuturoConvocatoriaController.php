<?php

namespace Drupal\colfuturo_convocatoria\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class ColfuturoConvocatoriaController.
 */
class ColfuturoConvocatoriaController extends ControllerBase {

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
   * Constructs a new ColfuturoConvocatoriaController object.
   */
  public function __construct(CurrentRouteMatch $current_route_match, AccountProxyInterface $current_user) {

    $session = \Drupal::request()->getSession();

    $this->currentRouteMatch = $current_route_match;
    $this->currentUser = $current_user;
    $this->session = json_decode($session->get('miniorange_congito_oauth2'), true);

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match'),
      $container->get('current_user')
    );
  }

  /**
   * interno.
   *
   * @return string
   *   Return Hello string.
   */
  public function interno() {
    $CI = new RedirectResponse('http://10.40.142.8:8180/convocatoriaAdmin/login.jsf' . '?id_token=' . $this->session['IdToken'] );
    $CI->send();
    return new Response(); 
  }


  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function externo() {

    $CI = new RedirectResponse('http://169.47.71.245:31613/convocatoria/login.jsf' . '?id_token=' . $this->session['IdToken'] );
    $CI->send();
    return new Response(); 
  }

  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function agenda() {

    $CI = new RedirectResponse('https://app.acuityscheduling.com/schedule.php?owner=13746351&notembedded=1' . '&id_token=' . $this->session['IdToken'] );
    $CI->send();
    return new Response(); 
  }

  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function solicita() {

    $CI = new RedirectResponse('https://app.acuityscheduling.com/schedule.php?owner=13746351&notembedded=1' . '&id_token=' . $this->session['IdToken'] );
    $CI->send();
    return new Response(); 
  }
}
