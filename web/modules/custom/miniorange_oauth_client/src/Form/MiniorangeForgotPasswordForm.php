<?php

namespace Drupal\miniorange_oauth_client\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\colfuturo_apps\AwsCognitoService;
use Drupal\colfuturo_apps\InterfaceAwsCognitoService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\miniorange_oauth_client\Controller\miniorange_oauth_clientController;


/**
 * Class HelloForm.
 */
class MiniorangeForgotPasswordForm extends FormBase {

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
    return 'miniorange_forgot_password_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    
    $form['description'] = [
        '#type' => 'item',
        '#description' => $this->t('Into your identification number'),
    ];


    $form['identification'] = [
      '#type' => 'number',
      '#title' => $this->t('Identification'),
      '#maxlength' => 13,
      '#size' => 20,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => array('class' => array('btn btn-primary', 'submitButton-customizable')),
      '#required' => true
      
    ];

    $form['register_uri'] = array( 
      '#type' => 'markup',
      '#markup' => '<p class="redirect-customizable">
                        <span>'.$this->t('I need a acccount?').'</span>&nbsp;<a href="'.$this->register_uri.'">'.$this->t('Sign Up').'</a>
                    </p>',
    );

    $form['#theme'] = 'miniorange_oauth_client_forgot_password_form';
    $form['#attached']['library'][] = 'miniorange_oauth_client/miniorange_oauth_client.login_form';


    return $form; 
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    try{
      
      $response = $this->aws_cognito->client->sendForgottenPasswordRequest($form_state->getValue('identification'));

    }catch(\Exception $e){

      $message = ($e->previous) ? $e->previous->getMessage(): $e->getMessage();
      $message = json_decode(trim(end(explode("-",end(explode("\n",$message))))));
      $form_state->setError($form['identification'], $this->t($message->message) );
      return;
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
   
    
    $form_state->setRedirect(
      'miniorange_oauth_client.cognito_confirm_forgot_password', 
      ['identification' => $form_state->getValue('identification')]
    );
    
  }

}