<?php

namespace Drupal\colfuturo_convocatoria\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class ColfuturoConvocatoriaSettingsForm extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'colfuturo_convocatoria_settings_form.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'colfuturo_convocatoria_settings_form';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];   
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config(static::SETTINGS);
    
    if( isset( $form_state ) && is_null($form_state->get('num_fields') ) ){
      $form_state->set('num_fields', 0);
    }


    $form['description'] = [
      '#markup' => '<div>' . $this->t('this form allow nullable Login After Redirect rules'). '</div>',
    ];

    $form['#tree'] = true;

    $form['paths_values'] = [
      '#type'   => 'field_set',
      '#title'  => $this->t('Path Values'),
      '#prefix' => '<div id="paths-values-fields-wrapper">',
      '#sufix' => '</div>',
    ];

    for($i = 0; $i <= $form_state->get('num_fields') ; $i++){
      $form['paths_values']['uri'][$i] = [
        '#type' => 'textfield',
        '#title' => $this->t('Uri' . $i),
        '#default_value' => $config->get('paths_values.uri.'.$i),
      ];  
    }
   

    $form['paths_values']['actions']['add_path_value'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add one'),
      '#submit' => ['::addOne'],
      '#ajax'  => [
        'callback'  => '::addOneCallback',
        'wrapper'   =>  'paths-values-fields-wrapper'],
    ];

    $form['paths_values']['actions']['remove_path_value'] = [
      '#type' => 'submit',
      '#value' => $this->t('Remove one'),
      '#submit' => ['::removeOne'],
      '#ajax' => [
        'callback'  => '::removeOneCallback',
        'wrapper'   =>  'paths-values-fields-wrapper'],
    ];
   

    $form_state->setCached(FALSE);

    $form['actions'] = [
      '#type' => 'actions'
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    //return parent::buildForm($form, $form_state);
    return $form;
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    
    $save = $this->configFactory->getEditable(static::SETTINGS);
      // Set the submitted configuration setting.
    foreach( $form_state->getValue('paths_values')['uri'] as $key => $value ) {
      $save->set('paths_values.uri.'.$key, $value);
    }
    
    $save->save();

    parent::submitForm($form, $form_state);
  }

  public function addOne(array $form, FormStateInterface $form_state) {

    $name_field = $form_state->get('num_fields');
    $add_field = $name_field + 1;
    $form_state->set('num_fields', $add_field);
    $form_state->setRebuild();

  }

  public function addOneCallback(array $form, FormStateInterface $form_state){

    $name_field = $form_state->get('num_fields');
    return $form['paths_values'];

  }

  public function removeOne(array $form, FormStateInterface $form_state){
    $name_field = $form_state->get('num_fields');
    $remove_field = $name_field - 1;
    $form_state->set('num_fields', $remove_field);
    $form_state->setRebuild();

  }

  public function removeOneCallback(array $form, FormStateInterface $form_state) {

    $name_field = $form_state->get('num_fields');
    return $form['paths_values'];

  }



}