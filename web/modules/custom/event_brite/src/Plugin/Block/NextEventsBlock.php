<?php

namespace Drupal\event_brite\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'NextEventsBlock' block.
 *
 * @Block(
 *  id = "nextevents",
 *  admin_label = @Translation("Next Events"),
 * )
 */
class NextEventsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
          ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['inputtext'] = [
      '#type' => 'text_format',
      '#title' => $this->t('InputText'),
      '#description' => $this->t('Just an input text'),
      '#default_value' => $this->configuration['inputtext'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['inputtext'] = $form_state->getValue('inputtext');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme']  = 'nextevents';
    $build['default_block_inputtext']['#markup'] = '<p>' . $this->configuration['inputtext'] . '</p>';
    $build['#events']   = $this->getEventsData()->events;  
    $build['#events'] = array_chunk($build['#events'], 3, true);
    dpm($build['#events']);
    return $build;
  }



  public function getEventsData(){
    $data = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?token=BJHRZYF254GXBOV7A6J6');
    return json_decode($data);
  }


}
