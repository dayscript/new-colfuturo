<?php

namespace Drupal\event_brite\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'NextEventsPcbBlock' block.
 *
 * @Block(
 *  id = "next_events_pcb",
 *  admin_label = @Translation("Next Events Programa Crédito Beca"),
 * )
 */
class NextEventsPcbBlock extends BlockBase {

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
/*    $data = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?order_by=start_asc&time_filter=current_future&organizer_filter=27056775865&token=Z5PUBQ6ROR7OYZM7YARV');
    $results = json_decode($data);
    dpm($results->events);
    //dpm($data["events"]);

    $builtForm = \Drupal::formBuilder()->getForm('Drupal\event_brite\Form\NextEventsForm');
    $renderArray['form'] = $builtForm;

    return $renderArray;*/
    $build = [];
    $build['#theme']  = 'next_events_pcb';
    $build['default_block_inputtext']['#markup'] = '<p>' . $this->configuration['inputtext'] . '</p>';
    $build['#events']   = $this->getEventsData()->events;  
    $build['#events'] = array_chunk($build['#events'], 3, true);
    //dpm($build['#events']);
    return $build;
  }

  public function getEventsData(){
    # Get all events of Programa Crédito Beca id=27056775865
    $data = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?order_by=start_asc&time_filter=current_future&organizer_filter=27056775865&token=Z5PUBQ6ROR7OYZM7YARV');
    return json_decode($data);
  } 
}