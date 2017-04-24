<?php

namespace Drupal\render_array_print;

use Drupal\Core\Render\Element;
use Drupal\Core\Render\Renderer;
use Drupal\entity_print\Plugin\EntityPrintPluginManager;

/**
 * Class PrintBuilder.
 *
 * @package Drupal\render_array_print
 */
class PrintBuilder implements PrintBuilderInterface {
  
  /**
   * Drupal\Core\Render\Renderer definition.
   *
   * @var Drupal\Core\Render\Renderer
   */
  protected $renderer;
  
  /**
   * Drupal\entity_print\Plugin\EntityPrintPluginManager definition.
   *
   * @var Drupal\entity_print\Plugin\EntityPrintPluginManager
   */
  protected $entityPrintEngine;
  
  /**
   * Constructor.
   */
  public function __construct(Renderer $renderer, EntityPrintPluginManager $plugin_manager_entity_print_print_engine) {
    $this->renderer = $renderer;
    $this->entityPrintEngine = $plugin_manager_entity_print_print_engine;
  }
  
  /**
   * @param array $renderArray
   * @param $exportType
   * @param string $filename
   * @param int $force_download
   */
  public function renderPrint(array $renderArray, $exportType, $filename = 'rendered array',$force_download = 0) {
    $entityPrintEngineInstance = $this->entityPrintEngine->createSelectedInstance($exportType);
    // Exclude the children with the key #exclude_from_print
    $renderArrayData = $this->searchNestedArrayKey($renderArray, '#exclude_from_print');
    $html = $this->renderer->renderRoot($renderArrayData);
    $entityPrintEngineInstance->addPage($html);
    $entityPrintEngineInstance->send($filename, $force_download);
  }
  
  /**
   * @param $element
   * @param $key
   * @return array
   */
  protected function searchNestedArrayKey(&$element, $key) {
    if (isset($element[$key])) {
      unset($element);
      return [];
    }
    $children = Element::children($element);
    if (!empty($children)) {
      
      foreach ($children as $item) {
        if (isset($element[$item][$key])) {
          unset($element[$item]);
        }
        else {
          $subChild = Element::children($element[$item]);
          if (!empty($subChild)) {
            $this->searchNestedArrayKey($element[$item], $key);
          }
        }
      }
    }
    return $element;
  }
  
}
