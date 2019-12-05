<?php

namespace Drupal\colfuturo_convocatoria\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Provides automated tests for the colfuturo_convocatoria module.
 */
class ColfuturoConvocatoriaControllerTest extends WebTestBase {

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
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "colfuturo_convocatoria ColfuturoConvocatoriaController's controller functionality",
      'description' => 'Test Unit for module colfuturo_convocatoria and controller ColfuturoConvocatoriaController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests colfuturo_convocatoria functionality.
   */
  public function testColfuturoConvocatoriaController() {
    // Check that the basic functions of module colfuturo_convocatoria.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
