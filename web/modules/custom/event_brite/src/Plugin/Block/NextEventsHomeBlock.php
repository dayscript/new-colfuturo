<?php

namespace Drupal\event_brite\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'NextEventsHomeBlock' block.
 *
 * @Block(
 *  id = "next_events_home",
 *  admin_label = @Translation("Next Events Home"),
 * )
 */
class NextEventsHomeBlock extends BlockBase {

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
    $build['#theme']  = 'next_events_home';
    $build['default_block_inputtext']['#markup'] = '<p>' . $this->configuration['inputtext'] . '</p>';
    $build['#events']   = $this->getEventsData()->events;  
    $build['#events'] = array_chunk($build['#events'], 3, true);
    //dpm($build['#events']);
    return $build;
  }

  public function getEventsData(){
    # Get next 3 events of all programs
    $data = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?order_by=start_asc&page_size=3&time_filter=current_future&token=Z5PUBQ6ROR7OYZM7YARV');
    return json_decode($data);
  } 
}