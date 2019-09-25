<?php
/**
 * @file
 * Contains \Drupal\event_brite\Controller\EventBrideController.
 */
namespace Drupal\event_brite\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class EventBriteController extends ControllerBase {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello world'),
    );
  }
}