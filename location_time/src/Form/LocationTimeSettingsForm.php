<?php

namespace Drupal\location_time\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Builds LocationTime Admin Form.
 */
class LocationTimeSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'location_time.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'location_time_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('location_time.settings');

    $form['location_time_setting'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Location Time Configuration'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    ];

    $form['location_time_setting']['country'] = [
      '#title' => $this->t('Country'),
      '#type' => 'textfield',
      '#default_value' => $config->get('country'),
    ];

    $form['location_time_setting']['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    ];

    $timezone = [
      'America/Chicago' => t('America/Chicago'),
      'America/New_York' => t('America/New_York'),
      'Asia/Tokyo' => t('Asia/Tokyo'),
      'Asia/Dubai' => t('Asia/Dubai'),
      'Asia/Kolkata' => t('Asia/Kolkata'),
      'Europe/Amsterdam' => t('Europe/Amsterdam'),
      'Europe/Oslo' => t('Europe/Oslo'),
      'Europe/London' => t('Europe/London'),
    ];

    $form['location_time_setting']['timezone'] = [
      '#type' => 'select',
      '#title' => t('Select your timezone'),
      '#options' => $timezone,
      '#default_value' => $config->get('timezone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // $values = $form_state->getValue('country');
    // dump($values);exit;
    $this->config('location_time.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))->save();

    parent::submitForm($form, $form_state);
  }

}
