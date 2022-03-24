<?php

namespace Drupal\location_time;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Provides a 'DatetimeDataService' service.
 */
class DatetimeDataService implements TrustedCallbackInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The Date format variable.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormat;

  /**
   * Constructs a new DatetimeData service.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Core\Datetime\DateFormatter $date_format
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, DateFormatter $date_format) {
    $this->configFactory = $config_factory;
    $this->dateFormat = $date_format;
  }

  /**
   * Returns datetime based on timezone selected by user.
   *
   * @return array
   *   An render array to display datetime.
   */
  public function getDateTime() {
    $config = $this->configFactory->get('location_time.settings');
    $timezone = $config->get('timezone');
    $datetime = $this->dateFormat->format(time(), 'custom', "jS M Y \- g:i A", $timezone);
    return [
      '#markup' => $datetime,
    ];
  }

  /**
   * Returns country and city.
   *
   * @return array
   *   An Associative array with elements 'city' and 'country'.
   */
  public function getLocationData() {
    $result = [];
    $result['city'] = $this->configFactory->get('location_time.settings')->get('city');
    $result['country'] = $this->configFactory->get('location_time.settings')->get('country');
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks() {
    return ['getDateTime'];
  }

}
