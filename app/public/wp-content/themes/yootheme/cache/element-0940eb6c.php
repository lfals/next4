<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder/elements/countdown/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'countdown', 
  'title' => 'Countdown', 
  'group' => 'basic', 
  'icon' => $filter->apply('url', 'images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', 'images/iconSmall.svg', $file), 
  'element' => true, 
  'width' => 500, 
  'defaults' => [
    'show_separator' => true, 
    'show_label' => true, 
    'grid_column_gap' => 'small', 
    'grid_row_gap' => 'small', 
    'label_margin' => 'small', 
    'margin' => 'default'
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'date' => [
      'label' => 'Date', 
      'description' => 'Enter a date for the countdown to expire. Use the <a href="https://developer.mozilla.org/en/docs/Web/JavaScript/Reference/Global_Objects/Date/parse#ECMAScript_5_ISO-8601_format_support" target="_blank">ISO 8601 format</a>: <code>YYYY-MM-DDThh:mm:ssTZD</code>, e.g. <code>2017-05-01T22:00:00+00:00</code> (UTC time).', 
      'attrs' => []
    ], 
    'label_days' => [
      'label' => 'Labels', 
      'attrs' => [
        'placeholder' => 'Days'
      ]
    ], 
    'label_hours' => [
      'attrs' => [
        'placeholder' => 'Hours'
      ]
    ], 
    'label_minutes' => [
      'attrs' => [
        'placeholder' => 'Minutes'
      ]
    ], 
    'label_seconds' => [
      'attrs' => [
        'placeholder' => 'Seconds'
      ]
    ], 
    'show_label' => [
      'description' => 'Enter labels for the countdown time.', 
      'type' => 'checkbox', 
      'text' => 'Show Labels'
    ], 
    'grid_column_gap' => [
      'label' => 'Column Gap', 
      'description' => 'Set the size of the column gap between the numbers.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Medium' => 'medium', 
        'Default' => '', 
        'Large' => 'large', 
        'None' => 'collapse'
      ]
    ], 
    'grid_row_gap' => [
      'label' => 'Row Gap', 
      'description' => 'Set the size of the row gap between the numbers.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Medium' => 'medium', 
        'Default' => '', 
        'Large' => 'large', 
        'None' => 'collapse'
      ]
    ], 
    'show_separator' => [
      'label' => 'Separator', 
      'description' => 'Show a separator between the numbers.', 
      'type' => 'checkbox', 
      'text' => 'Show Separators'
    ], 
    'label_margin' => [
      'label' => 'Label Margin', 
      'description' => 'Set the margin between the countdown and the label text.', 
      'type' => 'select', 
      'options' => [
        'Default' => '', 
        'Small' => 'small', 
        'Medium' => 'medium', 
        'None' => 'remove'
      ], 
      'enable' => 'show_label'
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
    'text_align' => $config->get('builder.text_align'), 
    'text_align_breakpoint' => $config->get('builder.text_align_breakpoint'), 
    'text_align_fallback' => $config->get('builder.text_align_fallback'), 
    'animation' => $config->get('builder.animation'), 
    '_parallax_button' => $config->get('builder._parallax_button'), 
    'visibility' => $config->get('builder.visibility'), 
    'name' => $config->get('builder.name'), 
    'status' => $config->get('builder.status'), 
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
          'title' => 'Content', 
          'fields' => ['date', 'label_days', 'label_hours', 'label_minutes', 'label_seconds', 'show_label']
        ], [
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Countdown', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['grid_column_gap', 'grid_row_gap', 'show_separator', 'label_margin']
            ], [
              'label' => 'General', 
              'type' => 'group', 
              'fields' => ['position', 'position_left', 'position_right', 'position_top', 'position_bottom', 'position_z_index', 'margin', 'margin_remove_top', 'margin_remove_bottom', 'text_align', 'text_align_breakpoint', 'text_align_fallback', 'animation', '_parallax_button', 'visibility']
            ]]
        ], $config->get('builder.advanced')]
    ]
  ]
];
