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
class MiniorangeResetPasswordForm extends FormBase { 

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
    $identification = $_SESSION['access_identification_cognito'];

    $form['description'] = [
        '#type' => 'item',
        '#description' => $this->t('Is necessary reset your password.'),
    ];

    $form['identification'] = [
      '#type' => 'hidden',
      '#value' => $identification,
    ];
    

    $form['password'] = [
      '#title' => $this->t('New Password'),
      '#type' => 'password',
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];


    $form['confirm_password'] = [
      '#title' => $this->t('Confirm New Password'),
      '#type' => 'password',
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];


    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => array('class' => array('btn btn-primary', 'submitButton-customizable')),
      
    ];
    
    $form['#theme'] = 'miniorange_oauth_client_reset_password_form';
    $form['#attached']['library'][] = 'miniorange_oauth_client/miniorange_oauth_client.login_form';


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $cognito = \Drupal::service('colfuturo_apps.aws_cognito');
    
    try{
      $authenticationResponse = $cognito->client->respondToNewPasswordRequiredChallenge(
        $form_state->getValue('identification'), $form_state->getValue('password'), $_SESSION['access_token_cognito']
      );
    }catch(\Exception $e){
      
      $message = ($e->previous) ? $e->previous->getMessage(): $e->getMessage();
      $message = json_decode(trim(end(explode("-",end(explode("\n",$message))))));
      $form_state->setError($form['password'], $this->t($message->message) );
      return;
    
    }
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.

    drupal_set_message('the password has been updated succesfull, plase login.');

    $form_state->setRedirect('miniorange_oauth_client.cognito_login');

  }

}