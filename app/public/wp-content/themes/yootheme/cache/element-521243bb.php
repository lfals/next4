<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder/elements/divider/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'divider', 
  'title' => 'Divider', 
  'group' => 'basic', 
  'icon' => $filter->apply('url', 'images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', 'images/iconSmall.svg', $file), 
  'element' => true, 
  'width' => 500, 
  'defaults' => [
    'divider_element' => 'hr'
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'divider_style' => [
      'label' => 'Style', 
      'description' => 'Choose a divider style.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Icon' => 'icon', 
        'Small' => 'small', 
        'Vertical' => 'vertical'
      ]
    ], 
    'divider_element' => [
      'label' => 'HTML Element', 
      'description' => 'Choose one of the HTML elements to fit the semantic structure.', 
      'type' => 'select', 
      'options' => [
        'hr' => 'hr', 
        'div' => 'div'
      ]
    ], 
    'divider_align' => [
      'label' => 'Alignment', 
      'description' => 'Center, left and right alignment may depend on a breakpoint and require a fallback.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Left' => 'left', 
        'Center' => 'center', 
        'Right' => 'right'
      ], 
      'enable' => 'divider_style == \'small\''
    ], 
    'divider_align_breakpoint' => [
      'label' => 'Alignment Breakpoint', 
      'description' => 'Define the device width from which the alignment will apply.', 
      'type' => 'select', 
      'options' => [
        'Always' => '', 
        'Small (Phone Landscape)' => 's', 
        'Medium (Tablet Landscape)' => 'm', 
        'Large (Desktop)' => 'l', 
        'X-Large (Large Screens)' => 'xl'
      ], 
      'enable' => 'divider_style == \'small\' && divider_align'
    ], 
    'divider_align_fallback' => [
      'label' => 'Alignment Fallback', 
      'description' => 'Define an alignment fallback for device widths below the breakpoint.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Left' => 'left', 
        'Center' => 'center', 
        'Right' => 'right'
      ], 
      'enable' => 'divider_style == \'small\' && divider_align && divider_align_breakpoint'
    ], 
    'position' => $config->get('builder.position'), 
    'position_left' => $config->get('builder.position_left'), 
    'position_right' => $config->get('builder.position_right'), 
    'position_top' => $config->get('builder.position_top'), 
    'position_bottom' => $config->get('builder.position_bottom'), 
    'position_z_index' => $config->get('builder.position_z_index'), 
    'margin' => $config->get('builder.margin'), 
    'margin_remove_top' => $config->get('builder.margin_remove_top'), 
    'margin_remove_bottom' => $config->get('builder.margin_remove_bottom'), 
    'maxwidth' => $config->get('builder.maxwidth'), 
    'maxwidth_breakpoint' => $config->get('builder.maxwidth_breakpoint'), 
    'block_align' => $config->get('builder.block_align'), 
    'block_align_breakpoint' => $config->get('builder.block_align_breakpoint'), 
    'block_align_fallback' => $config->get('builder.block_align_fallback'), 
    'animation' => $config->get('builder.animation'), 
    '_parallax_button' => $config->get('builder._parallax_button'), 
    'visibility' => $config->get('builder.visibility'), 
    'name' => $config->get('builder.name'), 
    'status' => $config->get('builder.status'), 
    'source' => $config->get('builder.source'), 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs'), 
    'css' => [
      'label' => 'CSS', 
      'description' => 'Enter your own custom CSS. The following selectors will be prefixed automatically for this element: <code>.el-element</code>', 
      'type' => 'editor', 
      'editor' => 'code', 
      'mode' => 'css', 
      'attrs' => [
        'debounce' => 500
      ]
    ]
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Divider', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['divider_style', 'divider_element', 'divider_align', 'divider_align_breakpoint', 'divider_align_fallback']
            ], [
              'label' => 'General', 
              'type' => 'group', 
              'fields' => ['position', 'position_left', 'position_right', 'position_top', 'position_bottom', 'position_z_index', 'margin', 'margin_remove_top', 'margin_remove_bottom', 'maxwidth', 'maxwidth_breakpoint', 'block_align', 'block_align_breakpoint', 'block_align_fallback', 'animation', '_parallax_button', 'visibility']
            ]]
        ], $config->get('builder.advanced')]
    ]
  ]
];
