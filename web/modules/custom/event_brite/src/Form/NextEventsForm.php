<?php

namespace Drupal\event_brite\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an event_brite form.
 */
class NextEventsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'next_events_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['month_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Example select field'),
      '#options' => [
        '1' => $this->t('One'),
        '2' => $this->t('Two'),
        '3' => $this->t('Three'),
        '4' => $this->t('From New York to Ger-ma-ny!'),
      ],
      '#ajax' => [
        'callback' => '::myAjaxCallback', // don't forget :: when calling a class method.
        //'callback' => [$this, 'myAjaxCallback'], //alternative notation
        'disable-refocus' => FALSE, // Or TRUE to prevent re-focusing on the triggering element.
        'event' => 'change',
        'wrapper' => 'edit-output', // This element is updated with this AJAX callback.
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Verifying entry...'),
        ],
      ]
    ];

    $form['container']['output'] = [
      '#type' => 'textfield',
      '#size' => '60',
      //'#disabled' => TRUE,
      '#value' => 'Hello, Drupal!!1',
      '#attributes' => [
        'id' => ['edit-output'],
      ],
    ];
/*    $form['month_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Select element'),
      '#options' => [
        '1' => $this->t('One'),
        '2' => $this->t('Two'),
        '3' => $this->t('Three'),
        '4' => $this->t('From New York to Ger-ma-ny!'),
      ],
    ];
*/
    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Your phone number'),
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('phone_number')) < 3) {
      $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('Your phone number is @number', ['@number' => $form_state->getValue('phone_number')]));
  }

  // Get the value from example select field and fill
  // the textbox with the selected text.
  public function myAjaxCallback(array &$form, FormStateInterface $form_state) {
    // Prepare our textfield. check if the example select field has a selected option.
    if ($selectedValue = $form_state->getValue('month_select')) {
        // Get the text of the selected option.
        $selectedText = $form['month_select']['#options'][$selectedValue];
        // Place the text of the selected option in our textfield.
        $form['container']['output']['#value'] = $selectedText;
    }
    // Return the prepared textfield.
    return $form['container']['output'];    
  }

}