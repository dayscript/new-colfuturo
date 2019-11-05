<?php

namespace Drupal\miniorange_oauth_client\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\colfuturo_apps\AwsCognitoService;
use Drupal\colfuturo_apps\InterfaceAwsCognitoService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\miniorange_oauth_client\Controller\miniorange_oauth_clientController;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class HelloForm.
 */
class MiniorangeVerifyForm extends FormBase {

  /**
   * Drupal\Core\Messenger\MessengerInterface definition.
   *
   * @var \Drupal\Core\Messenger\InterfaceAwsCognitoService
   */
  protected $aws_cognito;
  protected $register_uri;
  /**
   * Constructs a new HelloForm object.
   */
  public function __construct(
    InterfaceAwsCognitoService $aws_cognito
  ) {
    $this->aws_cognito = $aws_cognito;
    $this->register_uri = \Drupal\Core\Url::fromRoute('miniorange_oauth_client.cognito_register')->getInternalPath();
    $this->forgot_password =  \Drupal\Core\Url::fromRoute('miniorange_oauth_client.cognito_forgot_password')->getInternalPath();
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('colfuturo_apps.aws_cognito')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'miniorange_login_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $identification = \Drupal::routeMatch()->getParameter('identification');
    
    $form['description'] = [
        '#type' => 'item',
        '#description' => $this->t('Enter the code that your email has been sent'),
    ];

    $form['code'] = [
      '#type' => 'number',
      '#title' => $this->t('code'),
      '#maxlength' => 13,
      '#size' => 20,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
    ];

    $form['identification'] = [
      '#type' => 'hidden',
      '#value' => $identification,
    ];
    
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => array('class' => array('btn btn-primary', 'submitButton-customizable')),
      
    ];

    $form['#theme'] = 'miniorange_oauth_client_verify_form';
    $form['#attached']['library'][] = 'miniorange_oauth_client/miniorange_oauth_client.login_form';


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.

    $cognito = \Drupal::service('colfuturo_apps.aws_cognito');

    try {
        $cognito->client->confirmUserRegistration( $form_state->getValue('code'), $form_state->getValue('identification') );
    } catch (\Exception $e) {
      
    }

    $form_state->setRedirect('miniorange_oauth_client.cognito_login');

  }

}