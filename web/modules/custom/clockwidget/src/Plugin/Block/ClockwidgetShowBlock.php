<?php

namespace Drupal\clockwidget\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "clockwidget_block",
 *   admin_label = @Translation("clockwidget blocks"),
 *   category = "clockwidget"
 * )
 */
class ClockwidgetShowBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('\Drupal\clockwidget\Form\ClockwidgetForm');
    return $form;
  }
  public function getCacheTags() {
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      return Cache::mergeTags(parent::getCacheTags(), array('node:' . $node->id()));
    } else {
      return parent::getCacheTags();
    }
  }

  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
  }
}
