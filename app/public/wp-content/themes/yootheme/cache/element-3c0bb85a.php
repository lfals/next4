<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder/elements/map/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'map', 
  'title' => 'Map', 
  'group' => 'multiple items', 
  'icon' => $filter->apply('url', 'images/icon.svg', $file), 
  'iconSmall' => $filter->apply('url', 'images/iconSmall.svg', $file), 
  'element' => true, 
  'container' => true, 
  'width' => 500, 
  'defaults' => [
    'show_title' => true, 
    'show_meta' => true, 
    'show_content' => true, 
    'show_image' => true, 
    'show_link' => true, 
    'type' => 'roadmap', 
    'zoom' => 10, 
    'controls' => true, 
    'zooming' => false, 
    'dragging' => false, 
    'min_zoom' => 0, 
    'max_zoom' => 18, 
    'title_hover_style' => 'reset', 
    'title_element' => 'h3', 
    'meta_style' => 'meta', 
    'meta_align' => 'below-title', 
    'meta_element' => 'div', 
    'image_svg_color' => 'emphasis', 
    'link_text' => 'Read more', 
    'link_style' => 'default', 
    'margin' => 'default'
  ], 
  'placeholder' => [
    'children' => [[
        'type' => 'list_item', 
        'props' => []
      ]]
  ], 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'content' => [
      'label' => 'Items', 
      'type' => 'content-items', 
      'title' => 'title', 
      'button' => 'Add Item', 
      'item' => 'map_item'
    ], 
    'show_title' => [
      'label' => 'Display', 
      'type' => 'checkbox', 
      'text' => 'Show the title'
    ], 
    'show_meta' => [
      'type' => 'checkbox', 
      'text' => 'Show the meta text'
    ], 
    'show_content' => [
      'type' => 'checkbox', 
      'text' => 'Show the content'
    ], 
    'show_image' => [
      'type' => 'checkbox', 
      'text' => 'Show the image'
    ], 
    'show_link' => [
      'description' => 'Show or hide content fields without the need to delete the content itself.', 
      'type' => 'checkbox', 
      'text' => 'Show the link'
    ], 
    'marker_icon' => [
      'label' => 'Marker Icon', 
      'type' => 'image'
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
    'cluster_icon_1' => [
      'label' => 'Cluster Icon (< 10 Markers)', 
      'type' => 'image'
    ], 
    'cluster_icon_1_width' => [
      'label' => 'Width', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'cluster_icon_1'
    ], 
    'cluster_icon_1_height' => [
      'label' => 'Height', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'cluster_icon_1'
    ], 
    'cluster_icon_1_text_color' => [
      'label' => 'Text Color', 
      'type' => 'color', 
      'enable' => 'cluster_icon_1'
    ], 
    'cluster_icon_2' => [
      'label' => 'Cluster Icon (< 100 Markers)', 
      'type' => 'image'
    ], 
    'cluster_icon_2_width' => [
      'label' => 'Width', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'cluster_icon_2'
    ], 
    'cluster_icon_2_height' => [
      'label' => 'Height', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'cluster_icon_2'
    ], 
    'cluster_icon_2_text_color' => [
      'label' => 'Text Color', 
      'type' => 'color', 
      'enable' => 'cluster_icon_2'
    ], 
    'cluster_icon_3' => [
      'label' => 'Cluster Icon (100+ Markers)', 
      'type' => 'image'
    ], 
    'cluster_icon_3_width' => [
      'label' => 'Width', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'cluster_icon_3'
    ], 
    'cluster_icon_3_height' => [
      'label' => 'Height', 
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'cluster_icon_3'
    ], 
    'cluster_icon_3_text_color' => [
      'label' => 'Text Color', 
      'type' => 'color', 
      'enable' => 'cluster_icon_3'
    ], 
    'type' => [
      'label' => 'Type', 
      'description' => 'Choose a map type.', 
      'type' => 'select', 
      'options' => [
        'Roadmap' => 'roadmap', 
        'Satellite' => 'satellite'
      ]
    ], 
    'zoom' => [
      'label' => 'Zoom', 
      'description' => 'Set the initial resolution at which to display the map. 0 is fully zoomed out and 18 is at the highest resolution zoomed in.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 18, 
        'step' => 1
      ]
    ], 
    'controls' => [
      'label' => 'Controls', 
      'description' => 'Display the map controls and define whether the map can be zoomed or dragged using the mouse wheel or touch.', 
      'type' => 'checkbox', 
      'text' => 'Show map controls'
    ], 
    'zooming' => [
      'type' => 'checkbox', 
      'text' => 'Enable map zooming'
    ], 
    'dragging' => [
      'type' => 'checkbox', 
      'text' => 'Enable map dragging'
    ], 
    'min_zoom' => [
      'label' => 'Minimum Zoom', 
      'description' => 'Minimum zoom level of the map.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 18, 
        'step' => 1
      ], 
      'enable' => 'zooming'
    ], 
    'max_zoom' => [
      'label' => 'Maximum Zoom', 
      'description' => 'Maximum zoom level of the map.', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0, 
        'max' => 18, 
        'step' => 1
      ], 
      'enable' => 'zooming'
    ], 
    'viewport_height' => [
      'label' => 'Viewport Height', 
      'description' => 'The height can adapt to the height of the viewport. <br><br>Note: Make sure no height is set in the section settings when using one of the viewport options.', 
      'type' => 'select', 
      'options' => [
        'Auto' => '', 
        'Viewport' => 'full', 
        'Viewport (Minus 20%)' => 'percent', 
        'Viewport (Minus the following section)' => 'section'
      ]
    ], 
    'height' => [
      'label' => 'Height', 
      'description' => 'Set the height in pixels.', 
      'type' => 'text', 
      'enable' => '!viewport_height'
    ], 
    'width' => [
      'label' => 'Width', 
      'description' => 'Set the width in pixels. If no width is set, the map will take the full width and keep the height. Or use the width only to define the breakpoint from which the map starts to shrink preserving the aspect ratio.', 
      'type' => 'text', 
      'enable' => '!viewport_height'
    ], 
    'width_breakpoint' => [
      'type' => 'checkbox', 
      'text' => 'Use as breakpoint only', 
      'enable' => 'width && !viewport_height'
    ], 
    'styler_hue' => [
      'label' => 'Hue', 
      'description' => 'Set the hue, e.g. <i>#ff0000</i>.', 
      'type' => 'color', 
      'alpha' => false, 
      'enable' => 'this.Config.values.google_maps'
    ], 
    'styler_lightness' => [
      'label' => 'Lightness', 
      'description' => 'Set percentage change in lightness (Between -100 and 100).', 
      'type' => 'range', 
      'attrs' => [
        'min' => -100, 
        'max' => 100, 
        'step' => 1
      ], 
      'enable' => 'this.Config.values.google_maps'
    ], 
    'styler_invert_lightness' => [
      'type' => 'checkbox', 
      'text' => 'Invert lightness', 
      'enable' => 'this.Config.values.google_maps'
    ], 
    'styler_saturation' => [
      'label' => 'Saturation', 
      'description' => 'Set percentage change in saturation (Between -100 and 100).', 
      'type' => 'range', 
      'attrs' => [
        'min' => -100, 
        'max' => 100, 
        'step' => 1
      ], 
      'enable' => 'this.Config.values.google_maps'
    ], 
    'styler_gamma' => [
      'label' => 'Gamma', 
      'description' => 'Set percentage change in the amount of gamma correction (Between 0.01 and 10.0, where 1.0 applies no correction).', 
      'type' => 'range', 
      'attrs' => [
        'min' => 0.5, 
        'max' => 2, 
        'step' => 0.10000000000000001
      ], 
      'enable' => 'this.Config.values.google_maps'
    ], 
    'clustering' => [
      'label' => 'Clustering', 
      'type' => 'checkbox', 
      'text' => 'Enable marker clustering'
    ], 
    'popup_max_width' => [
      'label' => 'Popup max width', 
      'description' => 'Set a maximum width for the popup.', 
      'type' => 'text'
    ], 
    'title_style' => [
      'label' => 'Style', 
      'description' => 'Title styles differ in font-size but may also come with a predefined color, size and font.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Small' => 'heading-small', 
        'H1' => 'h1', 
        'H2' => 'h2', 
        'H3' => 'h3', 
        'H4' => 'h4', 
        'H5' => 'h5', 
        'H6' => 'h6'
      ], 
      'enable' => 'show_title'
    ], 
    'title_link' => [
      'label' => 'Link', 
      'description' => 'Link the title if a link exists.', 
      'type' => 'checkbox', 
      'text' => 'Link title', 
      'enable' => 'show_title && show_link'
    ], 
    'title_hover_style' => [
      'label' => 'Hover Style', 
      'description' => 'Set the hover style for a linked title.', 
      'type' => 'select', 
      'options' => [
        'None' => 'reset', 
        'Heading Link' => 'heading', 
        'Default Link' => ''
      ], 
      'enable' => 'show_title && show_link && title_link'
    ], 
    'title_decoration' => [
      'label' => 'Decoration', 
      'description' => 'Decorate the title with a divider, bullet or a line that is vertically centered to the heading.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Divider' => 'divider', 
        'Bullet' => 'bullet', 
        'Line' => 'line'
      ], 
      'enable' => 'show_title'
    ], 
    'title_font_family' => [
      'label' => 'Font Family', 
      'description' => 'Select an alternative font family.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Default' => 'default', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary', 
        'Tertiary' => 'tertiary'
      ], 
      'enable' => 'show_title'
    ], 
    'title_color' => [
      'label' => 'Color', 
      'description' => 'Select the text color. If the Background option is selected, styles that don\'t apply a background image use the primary color instead.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Muted' => 'muted', 
        'Emphasis' => 'emphasis', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary', 
        'Success' => 'success', 
        'Warning' => 'warning', 
        'Danger' => 'danger', 
        'Background' => 'background'
      ], 
      'enable' => 'show_title'
    ], 
    'title_element' => [
      'label' => 'HTML Element', 
      'description' => 'Choose one of the HTML elements to fit the semantic structure.', 
      'type' => 'select', 
      'options' => [
        'h1' => 'h1', 
        'h2' => 'h2', 
        'h3' => 'h3', 
        'h4' => 'h4', 
        'h5' => 'h5', 
        'h6' => 'h6', 
        'div' => 'div'
      ], 
      'enable' => 'show_title'
    ], 
    'title_margin' => [
      'label' => 'Margin Top', 
      'description' => 'Set the top margin. Note that the margin will only apply if the content field immediately follows another content field.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Default' => '', 
        'Medium' => 'medium', 
        'Large' => 'large', 
        'X-Large' => 'xlarge', 
        'None' => 'remove'
      ], 
      'enable' => 'show_title'
    ], 
    'meta_style' => [
      'label' => 'Style', 
      'description' => 'Select a predefined meta text style, including color, size and font-family.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Meta' => 'meta', 
        'H1' => 'h1', 
        'H2' => 'h2', 
        'H3' => 'h3', 
        'H4' => 'h4', 
        'H5' => 'h5', 
        'H6' => 'h6'
      ], 
      'enable' => 'show_meta'
    ], 
    'meta_color' => [
      'label' => 'Color', 
      'description' => 'Select the text color.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Muted' => 'muted', 
        'Emphasis' => 'emphasis', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary', 
        'Success' => 'success', 
        'Warning' => 'warning', 
        'Danger' => 'danger'
      ], 
      'enable' => 'show_meta'
    ], 
    'meta_align' => [
      'label' => 'Alignment', 
      'description' => 'Align the meta text.', 
      'type' => 'select', 
      'options' => [
        'Above Title' => 'above-title', 
        'Below Title' => 'below-title', 
        'Below Content' => 'below-content'
      ], 
      'enable' => 'show_meta'
    ], 
    'meta_element' => [
      'label' => 'HTML Element', 
      'description' => 'Choose one of the HTML elements to fit the semantic structure.', 
      'type' => 'select', 
      'options' => [
        'h1' => 'h1', 
        'h2' => 'h2', 
        'h3' => 'h3', 
        'h4' => 'h4', 
        'h5' => 'h5', 
        'h6' => 'h6', 
        'div' => 'div'
      ], 
      'enable' => 'show_meta'
    ], 
    'meta_margin' => [
      'label' => 'Margin Top', 
      'description' => 'Set the top margin. Note that the margin will only apply if the content field immediately follows another content field.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Default' => '', 
        'Medium' => 'medium', 
        'Large' => 'large', 
        'X-Large' => 'xlarge', 
        'None' => 'remove'
      ], 
      'enable' => 'show_meta'
    ], 
    'content_style' => [
      'label' => 'Style', 
      'description' => 'Select a predefined text style, including color, size and font-family.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Lead' => 'lead', 
        'Meta' => 'meta'
      ], 
      'enable' => 'show_content'
    ], 
    'content_margin' => [
      'label' => 'Margin Top', 
      'description' => 'Set the top margin. Note that the margin will only apply if the content field immediately follows another content field.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Default' => '', 
        'Medium' => 'medium', 
        'Large' => 'large', 
        'X-Large' => 'xlarge', 
        'None' => 'remove'
      ], 
      'enable' => 'show_content'
    ], 
    'image_width' => [
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'show_image'
    ], 
    'image_height' => [
      'attrs' => [
        'placeholder' => 'auto'
      ], 
      'enable' => 'show_image'
    ], 
    'image_border' => [
      'label' => 'Border', 
      'description' => 'Select the image\'s border style.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Rounded' => 'rounded', 
        'Circle' => 'circle', 
        'Pill' => 'pill'
      ], 
      'enable' => 'show_image'
    ], 
    'image_link' => [
      'label' => 'Link', 
      'description' => 'Link the image if a link exists.', 
      'type' => 'checkbox', 
      'text' => 'Link image', 
      'enable' => 'show_image && show_link'
    ], 
    'image_svg_inline' => [
      'label' => 'Inline SVG', 
      'description' => 'Inject SVG images into the page markup so that they can easily be styled with CSS.', 
      'type' => 'checkbox', 
      'text' => 'Make SVG stylable with CSS', 
      'enable' => 'show_image'
    ], 
    'image_svg_animate' => [
      'type' => 'checkbox', 
      'text' => 'Animate strokes', 
      'enable' => 'show_image && image_svg_inline'
    ], 
    'image_svg_color' => [
      'label' => 'SVG Color', 
      'description' => 'Select the SVG color. It will only apply to supported elements defined in the SVG.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Muted' => 'muted', 
        'Emphasis' => 'emphasis', 
        'Primary' => 'primary', 
        'Secondary' => 'secondary', 
        'Success' => 'success', 
        'Warning' => 'warning', 
        'Danger' => 'danger'
      ], 
      'enable' => 'show_image && image_svg_inline'
    ], 
    'link_target' => [
      'label' => 'Target', 
      'type' => 'checkbox', 
      'text' => 'Open in a new window', 
      'enable' => 'show_link'
    ], 
    'link_text' => [
      'label' => 'Text', 
      'description' => 'Enter the text for the link.', 
      'enable' => 'show_link'
    ], 
    'link_style' => [
      'label' => 'Style', 
      'description' => 'Set the link style.', 
      'type' => 'select', 
      'options' => [
        'Button Default' => 'default', 
        'Button Primary' => 'primary', 
        'Button Secondary' => 'secondary', 
        'Button Danger' => 'danger', 
        'Button Text' => 'text', 
        'Link' => '', 
        'Link Muted' => 'link-muted', 
        'Link Text' => 'link-text'
      ], 
      'enable' => 'show_link'
    ], 
    'link_size' => [
      'label' => 'Button Size', 
      'description' => 'Set the button size.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Default' => '', 
        'Large' => 'large'
      ], 
      'enable' => 'show_link && link_style && link_style != \'link-muted\' && link_style != \'link-text\''
    ], 
    'link_fullwidth' => [
      'type' => 'checkbox', 
      'text' => 'Full width button', 
      'enable' => 'show_link && link_style && link_style != \'link-muted\' && link_style != \'link-text\''
    ], 
    'link_margin' => [
      'label' => 'Margin Top', 
      'description' => 'Set the top margin. Note that the margin will only apply if the content field immediately follows another content field.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Default' => '', 
        'Medium' => 'medium', 
        'Large' => 'large', 
        'X-Large' => 'xlarge', 
        'None' => 'remove'
      ], 
      'enable' => 'show_link'
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
    'item_text_align' => [
      'label' => 'Text Alignment', 
      'description' => 'Center, left and right alignment may depend on a breakpoint and require a fallback.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Left' => 'left', 
        'Center' => 'center', 
        'Right' => 'right', 
        'Justify' => 'justify'
      ]
    ], 
    'item_text_align_breakpoint' => [
      'label' => 'Text Alignment Breakpoint', 
      'description' => 'Define the device width from which the alignment will apply.', 
      'type' => 'select', 
      'options' => [
        'Always' => '', 
        'Small (Phone Landscape)' => 's', 
        'Medium (Tablet Landscape)' => 'm', 
        'Large (Desktop)' => 'l', 
        'X-Large (Large Screens)' => 'xl'
      ], 
      'enable' => 'item_text_align && item_text_align != \'justify\''
    ], 
    'item_text_align_fallback' => [
      'label' => 'Text Alignment Fallback', 
      'description' => 'Define an alignment fallback for device widths below the breakpoint.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Left' => 'left', 
        'Center' => 'center', 
        'Right' => 'right', 
        'Justify' => 'justify'
      ], 
      'enable' => 'item_text_align && item_text_align != \'justify\' && item_text_align_breakpoint'
    ], 
    'animation' => $config->get('builder.animation'), 
    '_parallax_button' => $config->get('builder._parallax_button'), 
    'visibility' => $config->get('builder.visibility'), 
    'container_padding_remove' => $config->get('builder.container_padding_remove'), 
    'name' => $config->get('builder.name'), 
    'status' => $config->get('builder.status'), 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs'), 
    'css' => [
      'label' => 'CSS', 
      'description' => 'Enter your own custom CSS. The following selectors will be prefixed automatically for this element: <code>.el-element</code>, <code>.el-item</code>, <code>.el-title</code>, <code>.el-meta</code>, <code>.el-content</code>, <code>.el-image</code>, <code>.el-link</code>', 
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
          'fields' => ['content', 'show_title', 'show_meta', 'show_content', 'show_image', 'show_link', 'marker_icon', [
              'name' => '_marker_icon_dimension', 
              'type' => 'grid', 
              'width' => '1-2', 
              'fields' => ['marker_icon_width', 'marker_icon_height']
            ], 'cluster_icon_1', [
              'name' => '_cluster_icon_1_dimensions', 
              'type' => 'grid', 
              'width' => '1-3', 
              'fields' => ['cluster_icon_1_width', 'cluster_icon_1_height', 'cluster_icon_1_text_color']
            ], 'cluster_icon_2', [
              'name' => '_cluster_icon_2_dimensions', 
              'type' => 'grid', 
              'width' => '1-3', 
              'fields' => ['cluster_icon_2_width', 'cluster_icon_2_height', 'cluster_icon_2_text_color']
            ], 'cluster_icon_3', [
              'name' => '_cluster_icon_3_dimensions', 
              'type' => 'grid', 
              'width' => '1-3', 
              'fields' => ['cluster_icon_3_width', 'cluster_icon_3_height', 'cluster_icon_3_text_color']
            ]]
        ], [
          'title' => 'Settings', 
          'fields' => [[
              'label' => 'Map', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['type', 'zoom', 'controls', 'zooming', 'dragging', 'min_zoom', 'max_zoom', 'viewport_height', 'height', 'width', 'width_breakpoint']
            ], [
              'label' => 'Style', 
              'description' => 'Only available for Google Maps.', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['styler_hue', 'styler_lightness', 'styler_invert_lightness', 'styler_saturation', 'styler_gamma']
            ], [
              'label' => 'Marker', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['clustering', 'popup_max_width']
            ], [
              'label' => 'Title', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['title_style', 'title_link', 'title_hover_style', 'title_decoration', 'title_font_family', 'title_color', 'title_element', 'title_margin']
            ], [
              'label' => 'Meta', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['meta_style', 'meta_color', 'meta_align', 'meta_element', 'meta_margin']
            ], [
              'label' => 'Content', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['content_style', 'content_margin']
            ], [
              'label' => 'Image', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => [[
                  'label' => 'Width/Height', 
                  'description' => 'Setting just one value preserves the original proportions. The image will be resized and cropped automatically, and where possible, high resolution images will be auto-generated.', 
                  'type' => 'grid', 
                  'width' => '1-2', 
                  'fields' => ['image_width', 'image_height']
                ], 'image_border', 'image_link', 'image_svg_inline', 'image_svg_animate', 'image_svg_color']
            ], [
              'label' => 'Link', 
              'type' => 'group', 
              'divider' => true, 
              'fields' => ['link_target', 'link_text', 'link_style', 'link_size', 'link_fullwidth', 'link_margin']
            ], [
              'label' => 'General', 
              'type' => 'group', 
              'fields' => ['position', 'position_left', 'position_right', 'position_top', 'position_bottom', 'position_z_index', 'margin', 'margin_remove_top', 'margin_remove_bottom', 'maxwidth', 'maxwidth_breakpoint', 'block_align', 'block_align_breakpoint', 'block_align_fallback', 'item_text_align', 'item_text_align_breakpoint', 'item_text_align_fallback', 'animation', '_parallax_button', 'visibility', 'container_padding_remove']
            ]]
        ], $config->get('builder.advanced')]
    ]
  ]
];
