<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder/elements/map_item/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'map_item', 
  'title' => 'Item', 
  'width' => 500, 
  'placeholder' => [
    'props' => [
      'location' => '53.5503, 10.0006'
    ]
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'location' => [
      'label' => 'Location', 
      'type' => 'location', 
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
    'marker_icon' => [
      'label' => 'Marker Icon', 
      'type' => 'image', 
      'source' => true
    ], 
    'marker_icon_width' => [
      'label' => 'Width', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'marker_icon'
    ], 
    'marker_icon_height' => [
      'label' => 'Height', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'marker_icon'
    ], 
    'hide' => [
      'label' => 'Marker', 
      'type' => 'checkbox', 
      'text' => 'Hide marker'
    ], 
    'show_popup' => [
      'label' => 'Popup', 
      'type' => 'checkbox', 
      'text' => 'Show popup on load'
    ], 
    'status' => $config->get('builder.statusItem'), 
    'source' => $config->get('builder.source')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['location', 'title', 'meta', 'content', 'image', 'image_alt', 'link', 'link_text', 'marker_icon', [
              'description' => 'Setting just one value preserves the original proportions. The image will be resized and cropped automatically, and where possible, high resolution images will be auto-generated.', 
              'name' => '_marker_dimension', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['marker_icon_width', 'marker_icon_height']
            ]]
        ], [
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Map', 
              'type' => 'group', 
              'fields' => ['hide', 'show_popup']
            ]]
        ], $config->get('builder.advancedItem')]
    ]
  ]
];
