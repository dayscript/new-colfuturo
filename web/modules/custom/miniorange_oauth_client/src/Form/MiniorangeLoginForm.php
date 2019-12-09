<?php

namespace Drupal\miniorange_oauth_client\Form;

use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\colfuturo_apps\AwsCognitoService;
use Drupal\colfuturo_apps\InterfaceAwsCognitoService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\miniorange_oauth_client\Controller\miniorange_oauth_clientController;
use pmill\AwsCognito\Exception\ChallengeException as ChallengeException;
use pmill\AwsCognito\Exception\PasswordResetRequiredException as PasswordResetRequiredException;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException as CognitoIdentityProviderException;




/**
 * Class HelloForm.
 */
class MiniorangeLoginForm extends FormBase {

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
    
    
    $form['description'] = [
        '#type' => 'item',
        '#description' => $this->t('Into login and password'),
    ];


    $form['identification'] = [
      '#type' => 'number',
      '#title' => $this->t('Identification'),
      '#maxlength' => 13,
      '#size' => 20,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
    ];
    
    $form['password'] = [
      '#title' => $this->t('Password'),
      '#type' => 'password',
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      '#required' => true
      
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => array('class' => array('btn btn-primary', 'submitButton-customizable')),
      '#required' => true
      
    ];

    $form['forgot_password'] = array(
      '#type' => 'markup',
      '#markup' => '<a class="redirect-customizable" href="'.$this->forgot_password.'">'.$this->t('forgot password').'</a>',
    );

    $form['register_uri'] = array( 
      '#type' => 'markup',
      '#markup' => '<p class="redirect-customizable">
                        <span>'.$this->t('I need a acccount?').'</span>&nbsp;<a href="'.$this->register_uri.'">'.$this->t('Sign Up').'</a>
                    </p>',
    );

    $form['#theme'] = 'miniorange_oauth_client_login_form';
    $form['#attached']['library'][] = 'miniorange_oauth_client/miniorange_oauth_client.login_form';


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    
    if(!$_SESSION){
      session_start();
    }
    
    \Drupal::service("page_cache_kill_switch")->trigger();
    \Drupal::configFactory()->getEditable("miniorange_oauth_client.settings")->set("navigation_url", $_SERVER["HTTP_REFERER"])->save();
    $y6 = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_app_name");
    $NA = base64_encode($y6);
    $_SESSION["oauth2state"] = $NA;
    $_SESSION["appname"] = $y6;

    
    try {
        $authenticationResponse = $this->aws_cognito->client->authenticate(
                $form_state->getValue('identification'), 
                $form_state->getValue('password')
            );
    } catch (ChallengeException $e) {
        
        if ($e->getChallengeName() === 'NEW_PASSWORD_REQUIRED') {

            drupal_set_message($this->t("Is necesary set new password"), 'warning');
            
            $_SESSION['access_token_cognito'] = $e->getSession();
            $_SESSION['access_identification_cognito'] = $form_state->getValue('identification');

            $form_state->{'RedirectForChallenge'} = 'ChallengeException' ;

            return true;
        }
        
    } catch (PasswordResetRequiredException $e) {
      
      try {

        $response = $this->aws_cognito->client->sendForgottenPasswordRequest($form_state->getValue('identification'));
        
      } catch(\ Exception $e){
        
        $message = ($e->previous) ? $e->previous->getMessage(): $e->getMessage();
        $message = json_decode(trim(end(explode("-",end(explode("\n",$message))))));
        $form_state->setError($form['identification'], $this->t($message->message) );
        return;
      
      }
      
      drupal_set_message( $this->t("Is necesary set new password"), 'warning');
      
      $form_state->{'RedirectForChallenge'} = 'PasswordResetRequiredException' ;

      return true;


    } catch( CognitoIdentityProviderException $e){
      
      $message = ($e->previous) ? $e->previous->getMessage(): $e->getMessage();
      $message = json_decode(trim(end(explode("-",end(explode("\n",$message))))));
      $form_state->setError($form['identification'], $this->t($message->message) );
      return;
    
    } catch( \Exception $e ){
      
      $message = ($e->previous) ? $e->previous->getMessage(): $e->getMessage();
      $message = json_decode(trim(end(explode("-",end(explode("\n",$message))))));
      $form_state->setError($form['identification'], $this->t($message->message) );
      return;

    }

    $session = \Drupal::request()->getSession();
    $session->set('miniorange_congito_oauth2', json_encode($authenticationResponse));

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    
    if($form_state->{'RedirectForChallenge'}){
      
      switch ($form_state->{'RedirectForChallenge'}) {

        case 'ChallengeException':
          $form_state->setRedirect('miniorange_oauth_client.cognito_reset_password');
          break;

        case 'PasswordResetRequiredException':
          $form_state->setRedirect(
            'miniorange_oauth_client.cognito_confirm_forgot_password', 
            ['identification' => $form_state->getValue('identification')]
          );
          break;
        
        default:
          # code...
          break;
      }

    }else{
      $current_path = \Drupal::service('path.current')->getPath() ?? NULL;
      $colfuturo_convocatoria_config = \Drupal::config('colfuturo_convocatoria_settings_form.settings')->get('paths_values.uri');
      // verify the module colfuturo_convocatoria config for alter the redirects in module redirec after login
      if(!is_null($current_path) && in_array($current_path, $colfuturo_convocatoria_config) ){
        $form_state->setRedirect('miniorange_oauth_client.mo_login_without_login_redirect');  
        
      }else{
        $form_state->setRedirect('miniorange_oauth_client.mo_login');
      }
    }
  }

}