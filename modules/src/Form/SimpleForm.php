<?php
/**
 * @file
 * Contains \Drupal\helloworld\Form\SimpleForm.
 *
 * В комментарии выше указываем, что содержится в данном файле.
 */


namespace Drupal\helloworld\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class SimpleForm extends FormBase {

  public $properties = [];
  /**
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'simple_form';
  }

  /**
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = \Drupal::config('helloworld.simple_form.settings');

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your name'),
      '#required' => TRUE
    );


    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your Last name'),
      '#required' => TRUE
    );

    $form['subject'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your Subject'),
      '#required' => TRUE
    );

    $form['message'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your message'),
      '#required' => TRUE
    );

    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => '',
      '#required' => TRUE,
      '#size' => '20',
      '#attributes' =>array('placeholder' => t('E-mail address'))
    );

    $form['button'] = array(
      '#type' => 'submit',
      '#value' => 'Submit'
    );


//    $form['actions']['#type'] = 'actions';
//    $form['actions']['submit'] = array(
//      '#type' => 'submit',
//      '#value' => $this->t('Send data'),
//      '#button_type' => 'primary',
//    );
    return $form;
  }

  /**
   *
   * {@inheritdoc}
   * @throws \Exception
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

//    if (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $form_state->getValue('email_')))
//    {
//      drupal_set_message($this->t('Thank you @name, your Email is @email', array(
//        '@name' => $form_state->getValue('name'),
//        '@email' => $form_state->getValue('email_')
//
//      )));
//
//    }
//    else
//    {
//
//      $form_state->setErrorByName('email_', $this->t('Your Email is incorrect'));
//    }
//  }
    if (strpos($form_state->getValue('email'), '.com') === FALSE) {

      $form_state->setErrorByName('email', 'E-mail is incorrect!');

    }

  }





  /**
   *
   * {@inheritdoc}
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $message = $form_state->getValue('message');

    $message = wordwrap($message, 70, "\r\n");

    $subject = $form_state->getValue('subject');

    $res = mail('info@mydrupal.com', $subject, $message);

    if($res) {

      \Drupal::logger('simple_form')->notice('Mail is sent. E-mail: '.$form_state->getValue('email'));

      drupal_set_message('E-mail is sent!');

    }

    $email = $form_state->getValue('email');
    $firstname = $form_state->getValue('first_name');
    $lastname = $form_state->getValue('last_name');

    $url = "https://api.hubapi.com/contacts/v1/contact/createOrUpdate/email/".$email."/?hapikey=8bc7dc9c-40de-4079-8b04-8bf5081671c6";

    $data = array(
      'properties' => [
        [
          'property' => 'firstname',
          'value' => $firstname
        ],
        [
          'property' => 'lastname',
          'value' => $lastname
        ]
      ]
    );

    $json = json_encode($data,true);

//    $request = \Drupal::httpClient()->post($url, NULL, $json);

    $response = \Drupal::httpClient()->post($url.'&_format=hal_json', [
      'headers' => [
        'Content-Type' => 'application/json'
      ],
      'body' => $json
    ]);
    }

}
