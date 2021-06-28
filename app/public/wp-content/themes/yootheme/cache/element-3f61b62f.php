<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder/elements/popover_item/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'popover_item', 
  'title' => 'Item', 
  'width' => 500, 
  'placeholder' => [
    'props' => [
      'title' => 'Title', 
      'meta' => '', 
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 
      'image' => ''
    ]
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'position_x' => [
      'label' => 'Left', 
      'description' => 'Enter the horizontal position of the marker in percent.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 100, 
        'step' => 1
      ], 
      'source' => true
    ], 
    'position_y' => [
      'label' => 'Top', 
      'description' => 'Enter the vertical position of the marker in percent.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 100, 
        'step' => 1
      ], 
      'source' => true
    ], 
    'title' => [
      'label' => 'Title', 
      'source' => true
    ], 
    'meta' => [
      'label' => 'Meta', 
      'source' => true
    ], 
    'content' => [
      'label' => 'Content', 
      'type' => 'editor', 
      'source' => true
    ], 
    'image' => $config->get('builder.image'), 
    'image_alt' => [
      'label' => 'Image Alt', 
      'source' => true, 
      'enable' => 'image'
    ], 
    'link' => $config->get('builder.link'), 
    'link_text' => [
      'label' => 'Link Text', 
      'description' => 'Set a different link text for this item.', 
      'source' => true, 
      'enable' => 'link'
    ], 
    'drop_position' => [
      'label' => 'Position', 
      'description' => 'Select a different position for this item.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Top' => 'top-center', 
        'Bottom' => 'bottom-center', 
        'Left' => 'left-center', 
        'Right' => 'right-center'
      ], 
      'source' => true
    ], 
    'status' => $config->get('builder.statusItem'), 
    'source' => $config->get('builder.source')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['position_x', 'position_y', 'title', 'meta', 'content', 'image', 'image_alt', 'link', 'link_text']
        ], [
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Popover', 
              'type' => 'group', 
              'fields' => ['drop_position']
            ]]
        ], $config->get('builder.advancedItem')]
    ]
  ]
];
