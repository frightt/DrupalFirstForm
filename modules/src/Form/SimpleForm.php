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

//    $form['phone_number'] = array(
//      '#type' => 'tel',
//      '#title' => $this->t('Your phone number'),
//      '#default_value' => $config->get('phone_number')
//    );

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your name')
    );


    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your Last name')
    );

    $form['Subject'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your Subject')
    );

    $form['messages'] = array(
      '#type' => 'textfield',
      '#size' => 'long',
      '#title' => $this->t('Your message')
    );

    $form['email_'] = array(
      '#type' => 'textfield',
      '#title' => '',
      '#size' => '20',
      '#attributes' =>array('placeholder' => t('E-mail address'))
    );


    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Send data'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   *
   * {@inheritdoc}
   * @throws \Exception
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
//    if (strlen($form_state->getValue('name')) < 5) {
//      $form_state->setErrorByName('name', $this->t('Name is too short.'));
//    }
    if (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $form_state->getValue('email_')))
    {
      drupal_set_message($this->t('Thank you @name, your Email is @email', array(
        '@name' => $form_state->getValue('name'),
        '@email' => $form_state->getValue('email_')

      )));

    }
    else
    {

      $form_state->setErrorByName('email_', $this->t('Your Email is incorrect'));
    }
  }



//  function my_form_mail($key, &$message, $params) {
//
//    $headers = array(
//      'MIME-Version' => '1.0',
//      'Content-Type' => 'text/html; charset=UTF-8;',
//      'Content-Transfer-Encoding' => '8Bit',
//      'X-Mailer' => 'Drupal'
//    );
//
//    foreach ($headers as $key => $value) {
//      $message['headers'][$key] = $value;
//    }
//
//    $message['subject'] = $params['subject'];
//    $message['body'] = $params['body'];
//  }


  /**
   *
   * {@inheritdoc}
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
//    $dk = db_insert('exampleform') -> fields(array(
//      'name' => $form_state['values'] ['fname'],
//      'last_name' => $form_state['values'] ['lname'],
//      'Subject' => $form_state['values']['subjectbd'],
//      'messages' => $form_state['values']['messagesbd'],
//      'phone_number' => $form_state['values']['phone_number'],
//      'email_' => $form_state['values']['	email'],
//
//    ))
//      -> execute();
//    dsm($dk);

//    drupal_set_message($this->t('Thank you @name, your Email is @email', array(
//      '@name' => $form_state->getValue('name'),
//      '@email' => $form_state->getValue('email_')
//    )));


  }

}
