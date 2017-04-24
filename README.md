# render_array_print

To print a render array use 

$renderArrayPrinter = \Drupal::service('render_array_print.builder');
    $arrayData = ['#markup'=>'Some String'];
    $renderArrayPrinter->renderPrint($arrayData,'pdf','somepdf.pdf',0);
    
any childelement in the render array with the key '#exclude_from_print' will be excluded from the print object