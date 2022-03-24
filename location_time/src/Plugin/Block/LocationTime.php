<?php

namespace Drupal\location_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\location_time\DatetimeDataService;

/**
 * Provides a 'LocationTime' block.
 *
 * @Block(
 *  id = "location_time",
 *  admin_label = @Translation("Location Time Display Block"),
 * )
 */
class LocationTime extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new LocationTime.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\location_time\DatetimeDataService $date_time
   *   The DatetimeDataService service.
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition, DatetimeDataService $date_time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dateTime = $date_time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('location_time.datetime_data_service')
    );
  }

  /**
   * Implements \Drupal\block\BlockBase::build().
   */
  public function build() {
    $location = $this->dateTime->getLocationData();
    return [
      '#theme' => 'location_time_display',
      '#location' => $location,
      '#datetime' => [
        '#lazy_builder' => [
          'location_time.datetime_data_service:getDateTime',
          [],
        ],
        '#create_placeholder' => TRUE,
      ],
    ];
  }

}
