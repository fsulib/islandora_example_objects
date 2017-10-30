<?php

namespace Drupal\islandora_example_objects\includes;
use Drupal\realistic_dummy_content_api\includes\RealisticDummyContentLogInterface;

/**
 * This log class can be used whenever you need to log data.
 */
class RealisticDummyContentWatchdogLog implements RealisticDummyContentLogInterface {

  /**
   * {@inheritdoc}
   */
  public function log($text, $vars = array()) {

  }

  /**
   * {@inheritdoc}
   */
  public function error($text, $vars = array()) {

  }

}
