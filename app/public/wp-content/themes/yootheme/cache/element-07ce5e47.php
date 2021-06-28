<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder-newsletter/elements/newsletter/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'newsletter', 
  'title' => 'Newsletter', 
  'group' => 'basic', 
  'icon' => $filter->apply('url', 'images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', 'images/iconSmall.svg', $file), 
  'element' => true, 
  'width' => 500, 
  'defaults' => [
    'layout' => 'grid', 
    'show_name' => true, 
    'label_first_name' => 'First name', 
    'label_last_name' => 'Last name', 
    'label_email' => 'Email address', 
    'label_button' => 'Subscribe', 
    'provider' => [
      'name' => 'mailchimp', 
      'after_submit' => 'message', 
      'message' => 'You\'ve been subscribed successfully.', 
      'redirect' => ''
    ], 
    'mailchimp' => [
      'client_id' => '', 
      'list_id' => '', 
      'double_optin' => true
    ], 
    'cmonitor' => [
      'client_id' => '', 
      'list_id' => ''
    ], 
    'button_mode' => 'button', 
    'button_style' => 'default', 
    'button_icon' => 'mail'
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file)
  ], 
  'fields' => [
    'provider.name' => [
      'label' => 'Provider', 
      'type' => 'select', 
      'options' => [
        'Mailchimp' => 'mailchimp', 
        'Campaign Monitor' => 'cmonitor'
      ]
    ], 
    'mailchimp' => [
      'label' => 'Mailchimp', 
      'type' => 'newsletter-lists', 
      'provider' => 'mailchimp', 
      'show' => 'provider.name == \'mailchimp\''
    ], 
    'mailchimp.double_optin' => [
      'label' => 'Double opt-in', 
      'type' => 'checkbox', 
      'text' => 'Use double opt-in.', 
      'show' => 'provider.name == \'mailchimp\''
    ], 
    'cmonitor' => [
      'label' => 'Campaign Monitor', 
      'type' => 'newsletter-lists', 
      'provider' => 'cmonitor', 
      'show' => 'provider.name == \'cmonitor\''
    ], 
    'provider.after_submit' => [
      'label' => 'After Submit', 
      'description' => 'Select whether a message will be shown or the site will be redirected after clicking the subscribe button.', 
      'type' => 'select', 
      'options' => [
        'Show message' => 'message', 
        'Redirect' => 'redirect'
      ]
    ], 
    'provider.message' => [
      'label' => 'Message', 
      'description' => 'Message shown to the user after submit.', 
      'type' => 'textarea', 
      'attrs' => [
        'rows' => 4
      ], 
      'show' => 'provider.after_submit == \'message\''
    ], 
    'provider.redirect' => [
      'label' => 'Link', 
      'description' => 'Link to redirect to after submit.', 
      'type' => 'link', 
      'filePicker' => false, 
      'show' => 'provider.after_submit == \'redirect\''
    ], 
    'layout' => [
      'label' => 'Layout', 
      'description' => 'Define the layout of the form.', 
      'type' => 'select', 
      'options' => [
        'Grid' => 'grid', 
        'Stacked' => 'stacked', 
        'Stacked (Name fields as grid)' => 'stacked-name'
      ]
    ], 
    'show_name' => [
      'type' => 'checkbox', 
      'text' => 'Show name fields'
    ], 
    'gap' => [
      'label' => 'Column Gap', 
      'description' => 'Set the size of the gap between the grid columns.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Medium' => 'medium', 
        'Default' => ''
      ]
    ], 
    'form_size' => [
      'label' => 'Size', 
      'description' => 'Select the form size.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Default' => '', 
        'Large' => 'large'
      ]
    ], 
    'form_style' => [
      'label' => 'Style', 
      'description' => 'Select the form style.', 
      'type' => 'select', 
      'options' => [
        'Default' => '', 
        'Blank' => 'blank'
      ]
    ], 
    'label_email' => [
      'label' => 'Email', 
      'attrs' => [
        'placeholder' => 'Email address'
      ]
    ], 
    'label_button' => [
      'label' => 'Button', 
      'attrs' => [
        'placeholder' => 'Submit'
      ]
    ], 
    'label_first_name' => [
      'label' => 'First name', 
      'attrs' => [
        'placeholder' => 'First name'
      ], 
      'enable' => 'show_name'
    ], 
    'label_last_name' => [
      'label' => 'Last name', 
      'attrs' => [
        'placeholder' => 'Last name'
      ], 
      'enable' => 'show_name'
    ], 
    'button_mode' => [
      'label' => 'Mode', 
      'description' => 'Select whether a button or a clickable icon inside the email input is shown.', 
      'type' => 'select', 
      'options' => [
        'Button' => 'button', 
        'Icon' => 'icon'
      ]
    ], 
    'button_style' => [
      'label' => 'Style', 
      'description' => 'Set the button style.', 
      'type' => 'select', 
      'options' => [
        'Default' => 'default', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary', 
        'Danger' => 'danger', 
        'Text' => 'text'
      ], 
      'enable' => 'button_mode == \'button\''
    ], 
    'button_fullwidth' => [
      'type' => 'checkbox', 
      'text' => 'Full width button', 
      'enable' => 'button_mode == \'button\' && layout != \'grid\''
    ], 
    'button_margin' => [
      'label' => 'Extra Margin', 
      'description' => 'Add extra margin to the button.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Small' => 'small', 
        'Medium' => 'default'
      ], 
      'enable' => 'button_mode == \'button\' && show_name'
    ], 
    'button_icon' => [
      'label' => 'Icon', 
      'description' => 'Click on the pencil to pick an icon from the SVG gallery.', 
      'type' => 'icon', 
      'enable' => 'button_mode == \'icon\''
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
    'text_align' => $config->get('builder.text_align_justify'), 
    'text_align_breakpoint' => $config->get('builder.text_align_breakpoint'), 
    'text_align_fallback' => $config->get('builder.text_align_justify_fallback'), 
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
      'description' => 'Enter your own custom CSS. The following selectors will be prefixed automatically for this element: <code>.el-element</code>, <code>.el-input</code>, <code>.el-button</code>', 
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
          'fields' => ['provider.name', 'mailchimp', 'mailchimp.double_optin', 'cmonitor', 'provider.after_submit', 'provider.message', 'provider.redirect']
        ], [
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Form', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['layout', 'show_name', 'gap', 'form_size', 'form_style']
            ], [
              'label' => 'Labels', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['label_email', 'label_button', 'label_first_name', 'label_last_name']
            ], [
              'label' => 'Button', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['button_mode', 'button_style', 'button_fullwidth', 'button_margin', 'button_icon']
            ], [
              'label' => 'General', 
              'type' => 'group', 
              'fields' => ['position', 'position_left', 'position_right', 'position_top', 'position_bottom', 'position_z_index', 'margin', 'margin_remove_top', 'margin_remove_bottom', 'maxwidth', 'maxwidth_breakpoint', 'block_align', 'block_align_breakpoint', 'block_align_fallback', 'text_align', 'text_align_breakpoint', 'text_align_fallback', 'animation', '_parallax_button', 'visibility']
            ]]
        ], [
          'title' => 'Advanced', 
          'fields' => ['name', 'status', 'id', 'class', 'css']
        ]]
    ]
  ]
];
