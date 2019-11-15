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
class MiniorangeRegisterForm extends FormBase {

  /**
   * Drupal\Core\Messenger\MessengerInterface definition.
   *
   * @var \Drupal\Core\Messenger\InterfaceAwsCognitoService
   */
  protected $aws_cognito;
  /**
   * Constructs a new HelloForm object.
   */
  public function __construct(
    InterfaceAwsCognitoService $aws_cognito
  ) {
    $this->aws_cognito = $aws_cognito;
    $this->login_uri = \Drupal\Core\Url::fromRoute('miniorange_oauth_client.cognito_login')->getInternalPath();
    // $this->errors = [
    //   'UsernameExistsException'  => [ ['identification'], $this->t('This user is already register') ],
    //   'InvalidPasswordException' => [ ['password'], $this->t('The password is not valid') ],
    //   'email'                    => [ ['email'], $this->t('The email is already ') ],
    //   'default'                  => [ [''], $this->t('try again') ]
    // ];
    
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
    
    
    $form['description'] = [
        '#type' => 'item',
        '#description' => $this->t('Complete the info'),
    ];


    $form['identification'] = [
      '#type' => 'number',
      '#title' => $this->t('Identification'),
      '#maxlength' => 13,
      '#size' => 20,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 50,
      '#size' => 53,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];

    $form['family_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Family Name'),
      '#maxlength' =>50,
      '#size' => 53,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#maxlength' => 50,
      '#size' => 53,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];
    
    $form['password'] = [
      '#title' => $this->t('Password'),
      '#type' => 'password',
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];

    $form['confirm_password'] = [
      '#title' => $this->t('Confirm Password'),
      '#type' => 'password',
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => array('class' => array('btn btn-primary', 'submitButton-customizable')),
      
    ];

    $form['login_uri'] = array( 
      '#type' => 'markup',
      '#markup' => '<p class="redirect-customizable">
                    <span>'.$this->t('You have a account?').'</span>&nbsp;<a href="' . $this->login_uri . '">'.$this->t('Sign In').'</a>
                    </p>',
    );

    $form['#theme'] = 'miniorange_oauth_client_register_form';
    $form['#attached']['library'][] = 'miniorange_oauth_client/miniorange_oauth_client.login_form';


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $cognito = \Drupal::service('colfuturo_apps.aws_cognito');
    $error_fields = [];
    $regular_expresion = '/^(?=.*?[A-Z a-z])[A-Z a-z+]+$/';


    //Validate Mail

    if(user_load_by_mail($form_state->getValue('email'))){
      $form_state->setError($form['email'], $this->t('This email @email is already', [ '@email' => $form_state->getValue('email')] ) );
      return;
    }

    preg_match($regular_expresion, $form_state->getValue('name'), $matches, PREG_OFFSET_CAPTURE, 0);
    if(!$matches){
      $form_state->setError($form['name'], $this->t('The field name only can have letters '));
      return;
    }

    preg_match($regular_expresion, $form_state->getValue('family_name'), $matches, PREG_OFFSET_CAPTURE, 0);
    if(!$matches){
      $form_state->setError($form['name'], $this->t('The field family name only can have letters '));
      return;
    }

    if( $form_state->getValue('password')  !=  $form_state->getValue('confirm_password')){
      $form_state->setError($form['confirm_password'], $this->t('The field password and field confirm password did not mach'));
      return;
    } 



    try {
      $cognito->client->registerUser(
        $form_state->getValue('identification'),
        $form_state->getValue('password'),
        [
          'email'             => $form_state->getValue('email'),
          'name'              => $form_state->getValue('name'),
          'family_name'       => $form_state->getValue('family_name'),
          'custom:Nombres'    => $form_state->getValue('name'),
          'custom:Apellidos'  => $form_state->getValue('family_name'),
          
        ]
      );
      $cognito->client->addUserToGroup($form_state->getValue('identification'), 'Potencial');

    } catch (\Exception $e) {
      
      $message = ($e->previous) ? $e->previous->getMessage(): $e->getMessage();
      $message = json_decode(trim(end(explode("-",end(explode("\n",$message))))));
      $form_state->setError($form['identification'], $message->message);
      return;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $form_state->setRedirect('miniorange_oauth_client.cognito_verify',['identification' => $form_state->getValue('identification')]);
  }

}