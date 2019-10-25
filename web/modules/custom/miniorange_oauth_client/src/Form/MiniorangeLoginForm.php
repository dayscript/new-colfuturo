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
class MiniorangeLoginForm extends FormBase {

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
        '#description' => $this->t('Sign in with your username and password'),
    ];


    $form['identification'] = [
      '#type' => 'number',
      '#title' => $this->t('Identification'),
      '#maxlength' => 13,
      '#size' => 20,
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
    ];
    
    $form['password'] = [
      '#title' => $this->t('Password'),
      '#type' => 'password',
      '#attributes' => array('class' => array('form-control', 'inputField-customizable')),
      
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => array('class' => array('btn btn-primary', 'submitButton-customizable')),
      
    ];

    $form['#theme'] = 'miniorange_oauth_client_login_form';
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
    \Drupal::service("page_cache_kill_switch")->trigger();
    \Drupal::configFactory()->getEditable("miniorange_oauth_client.settings")->set("navigation_url", $_SERVER["HTTP_REFERER"])->save();
    $y6 = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_app_name");
    $BY = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_client_id");
    $Oy = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_client_secret");
    $jb = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_scope");
    $KA = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_authorize_endpoint");
    $mS = \Drupal::config("miniorange_oauth_client.settings")->get("miniorange_auth_client_callback_uri");
    $NA = base64_encode($y6);
    if (strpos($KA, "?") !== false) {
        goto hE;
    }
    $KA = $KA . "?client_id=" . $BY . "&scope=" . $jb . "&redirect_uri=" . $mS . "&response_type=code&state=" . $NA;
    goto r3;
    hE:
        $KA = $KA . "&client_id=" . $BY . "&scope=" . $jb . "&redirect_uri=" . $mS . "&response_type=code&state=" . $NA;
    r3:
        $_SESSION["oauth2state"] = $NA;
        $_SESSION["appname"] = $y6;

    // Display result.
    $cognito = \Drupal::service('colfuturo_apps.aws_cognito');

    try {
        $authenticationResponse = $cognito->client->authenticate(
                $form_state->getValue('identification'), 
                $form_state->getValue('password')
            );
    } catch (ChallengeException $e) {
        if ($e->getChallengeName() === CognitoClient::CHALLENGE_NEW_PASSWORD_REQUIRED) {
            $authenticationResponse = $cognito->client->respondToNewPasswordRequiredChallenge($username, 'password_new', $e->getSession());
        }
    } catch (PasswordResetRequiredException $e) {
        die("PASSWORD RESET REQUIRED");
    }

    $_SESSION['miniorange_congito_oauth2'] = $authenticationResponse;
    // dump($cognito->client->decodeAccessToken($_SESSION['miniorange_congito_oauth2']['IdToken']));
    
    // die;

    $form_state->setRedirect('miniorange_oauth_client.mo_login');

    // foreach ($form_state->getValues() as $key => $value) {
    //   drupal_set_message($key . ': ' . $value);
    // }

  }

}