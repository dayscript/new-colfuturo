<?php

namespace Drupal\colfuturo_apps\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class ColfuturoAppsSettingsForm extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'colfuturo_apps_settings_form.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'colfuturo_apps_settings_form';
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

    $form['uri_redirect'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Uri Redirect'),
      '#default_value' => $config->get('uri_redirect'),
    ];  

    
    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('uri_redirect', $form_state->getValue('uri_redirect'))
     
      ->save();

    parent::submitForm($form, $form_state);
  }

}