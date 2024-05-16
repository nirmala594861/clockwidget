<?php

namespace Drupal\clockwidget\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 */
class ClockwidgetForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'clockwidget_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $options_category = ["EST" => "EST", "UTC" => "UTC", "GMT" => "GMT"];
    $json = file_get_contents('https://worldtimeapi.org/api/timezone/UTC');
    $the_json = json_decode($json, TRUE);
    // dsm($the_json['utc_datetime']);.
    $form['usertimezone'] = [
      '#type' => 'select',
      '#title' => t('Usertime'),
      '#required' => FALSE,
      '#options' => $options_category,
    //  '#default_value' => $options_category,
    ];
    $form['usertime'] = [
      '#title' => t('User Time zone'),
      '#type' => 'datetime',
      '#default_value' => $the_json['utc_datetime'],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add Time Zone'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    try {
      $conn = Database::getConnection();
      $current_user = \Drupal::currentUser();
      $uid = $current_user->id();
      $field = $form_state->getValues();
      $nodecreated = \Drupal::service('date.formatter')->format(strtotime($field['usertime']), 'custom', 'Y-m-d\TH:i:s');
      $fields["usertimezone"] = $field['usertimezone'];
      $fields["inviter_uid"] = $uid;
      $fields["date"] = $nodecreated;

      $conn->insert('usertimezone_schema')
        ->fields($fields)->execute();
      \Drupal::messenger()->addMessage($this->t('User time zone has been succesfully saved'));

    }
    catch (Exception $ex) {
      \Drupal::logger('usertimezone')->error($ex->getMessage());
    }

    // \Drupal::messenger()->addMessage($this->t('The Student data has been succesfully saved'));
  }

}
