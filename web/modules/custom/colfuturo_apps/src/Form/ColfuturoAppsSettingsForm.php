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

    $form['amazon_access_key_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Amazon Access key ID'),
      '#default_value' => $config->get('amazon_access_key_id'),
    ];  


    $form['amazon_secret_access_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Secret access key'),
      '#default_value' => $config->get('amazon_secret_access_key'),
    ];  


    $form['region'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Region'),
      '#default_value' => $config->get('region'),
    ];  

    $form['version'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Version'),
      '#default_value' => $config->get('version'),
    ];  

    $form['app_client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('App Client ID'),
      '#default_value' => $config->get('app_client_id'),
    ];  

    $form['app_client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('App Client Secret'),
      '#default_value' => $config->get('app_client_secret'),
    ];  

    $form['user_pool_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User Pool ID'),
      '#default_value' => $config->get('user_pool_id'),
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
      ->set('amazon_access_key_id', $form_state->getValue('amazon_access_key_id'))
      ->set('amazon_secret_access_key', $form_state->getValue('amazon_secret_access_key'))
      ->set('region', $form_state->getValue('region'))
      ->set('version', $form_state->getValue('version'))
      ->set('app_client_id', $form_state->getValue('app_client_id'))
      ->set('app_client_secret', $form_state->getValue('app_client_secret'))
      ->set('user_pool_id', $form_state->getValue('user_pool_id'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}