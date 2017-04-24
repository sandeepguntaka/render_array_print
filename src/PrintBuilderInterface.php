<?php

namespace Drupal\render_array_print;

/**
 * Interface PrintBuilderInterface.
 *
 * @package Drupal\render_array_print
 */
interface PrintBuilderInterface {
  public function renderPrint(array $renderArray, $exportType, $filename = 'rendered array');
  
}
