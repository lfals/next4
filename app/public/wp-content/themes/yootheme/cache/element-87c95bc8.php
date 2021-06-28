<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder/elements/social_item/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'social_item', 
  'title' => 'Item', 
  'width' => 500, 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'link' => [
      'label' => 'Link', 
      'attrs' => [
        'placeholder' => 'https://'
      ], 
      'source' => true, 
      'description' => 'Enter link to your social profile. A corresponding <a href="https://getuikit.com/docs/icon" target="_blank">UIkit brand icon</a> will be displayed automatically, if available. Links to email addresses and phone numbers, like mailto:info@example.com or tel:+491570156, are also supported.'
    ], 
    'icon' => [
      'label' => 'Icon', 
      'description' => 'Pick an alternative icon from the icon library.', 
      'type' => 'icon', 
      'source' => true, 
      'enable' => '!image'
    ], 
    'image' => [
      'label' => 'Image', 
      'description' => 'Pick an alternative SVG image from the media manager.', 
      'type' => 'image', 
      'source' => true, 
      'enable' => '!icon'
    ], 
    'status' => $config->get('builder.statusItem'), 
    'source' => $config->get('builder.source')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Content', 
          'fields' => ['link', 'icon', 'image']
        ], $config->get('builder.advancedItem')]
    ]
  ]
];
