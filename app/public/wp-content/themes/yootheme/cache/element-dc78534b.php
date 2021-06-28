<?php // $file = C:/Users/luisf/Local Sites/next/app/public/wp-content/themes/yootheme/vendor/yootheme/builder/elements/row/element.json

return [
  '@import' => $filter->apply('path', './element.php', $file), 
  'name' => 'row', 
  'title' => 'Row', 
  'container' => true, 
  'width' => 500, 
  'templates' => [
    'render' => $filter->apply('path', './templates/template.php', $file), 
    'content' => $filter->apply('path', './templates/content.php', $file)
  ], 
  'fields' => [
    'layout' => [
      'label' => 'Layout', 
      'type' => 'select-img', 
      'title' => 'Select a grid layout', 
      'options' => [
        '' => [
          'label' => 'Whole', 
          'src' => $filter->apply('url', 'images/whole.svg', $file)
        ], 
        '1-2,1-2' => [
          'label' => 'Halves', 
          'src' => $filter->apply('url', 'images/halves.svg', $file)
        ], 
        '1-3,1-3,1-3' => [
          'label' => 'Thirds', 
          'src' => $filter->apply('url', 'images/thirds.svg', $file)
        ], 
        '1-4,1-4,1-4,1-4|1-2,1-2,1-2,1-2' => [
          'label' => 'Quarters', 
          'src' => $filter->apply('url', 'images/quarters.svg', $file)
        ], 
        '1-5,1-5,1-5,1-5,1-5|1-2,1-2,1-3,1-3,1-3' => [
          'label' => 'Fifths', 
          'src' => $filter->apply('url', 'images/fifths.svg', $file)
        ], 
        '2-3,1-3' => [
          'label' => 'Thirds 2-1', 
          'src' => $filter->apply('url', 'images/thirds-2-1.svg', $file)
        ], 
        '1-3,2-3' => [
          'label' => 'Thirds 1-2', 
          'src' => $filter->apply('url', 'images/thirds-1-2.svg', $file)
        ], 
        '3-4,1-4' => [
          'label' => 'Quarters 3-1', 
          'src' => $filter->apply('url', 'images/quarters-3-1.svg', $file)
        ], 
        '1-4,3-4' => [
          'label' => 'Quarters 1-3', 
          'src' => $filter->apply('url', 'images/quarters-1-3.svg', $file)
        ], 
        '1-2,1-4,1-4|1-1,1-2,1-2' => [
          'label' => 'Quarters 2-1-1', 
          'src' => $filter->apply('url', 'images/quarters-2-1-1.svg', $file)
        ], 
        '1-4,1-4,1-2|1-2,1-2,1-1' => [
          'label' => 'Quarters 1-1-2', 
          'src' => $filter->apply('url', 'images/quarters-1-1-2.svg', $file)
        ], 
        '1-4,1-2,1-4' => [
          'label' => 'Quarters 1-2-1', 
          'src' => $filter->apply('url', 'images/quarters-1-2-1.svg', $file)
        ], 
        '2-5,3-5' => [
          'label' => 'Fifths 2-3', 
          'src' => $filter->apply('url', 'images/fifths-2-3.svg', $file)
        ], 
        '3-5,2-5' => [
          'label' => 'Fifths 3-2', 
          'src' => $filter->apply('url', 'images/fifths-3-2.svg', $file)
        ], 
        '1-5,4-5' => [
          'label' => 'Fifths 1-4', 
          'src' => $filter->apply('url', 'images/fifths-1-4.svg', $file)
        ], 
        '4-5,1-5' => [
          'label' => 'Fifths 4-1', 
          'src' => $filter->apply('url', 'images/fifths-4-1.svg', $file)
        ], 
        '3-5,1-5,1-5|1-1,1-2,1-2' => [
          'label' => 'Fifths 3-1-1', 
          'src' => $filter->apply('url', 'images/fifths-3-1-1.svg', $file)
        ], 
        '1-5,1-5,3-5|1-2,1-2,1-1' => [
          'label' => 'Fifths 1-1-3', 
          'src' => $filter->apply('url', 'images/fifths-1-1-3.svg', $file)
        ], 
        '1-5,3-5,1-5' => [
          'label' => 'Fifths 1-3-1', 
          'src' => $filter->apply('url', 'images/fifths-1-3-1.svg', $file)
        ], 
        '2-5,1-5,1-5,1-5|1-1,1-3,1-3,1-3' => [
          'label' => 'Fifths 2-1-1-1', 
          'src' => $filter->apply('url', 'images/fifths-2-1-1-1.svg', $file)
        ], 
        '1-5,1-5,1-5,2-5|1-3,1-3,1-3,1-1' => [
          'label' => 'Fifths 1-1-1-2', 
          'src' => $filter->apply('url', 'images/fifths-1-1-1-2.svg', $file)
        ], 
        'large,expand' => [
          'label' => 'Fixed-Left', 
          'src' => $filter->apply('url', 'images/fixed-left.svg', $file)
        ], 
        'expand,large' => [
          'label' => 'Fixed-Right', 
          'src' => $filter->apply('url', 'images/fixed-right.svg', $file)
        ], 
        'expand,large,expand' => [
          'label' => 'Fixed-Inner', 
          'src' => $filter->apply('url', 'images/fixed-inner.svg', $file)
        ], 
        'large,expand,large' => [
          'label' => 'Fixed-Outer', 
          'src' => $filter->apply('url', 'images/fixed-outer.svg', $file)
        ]
      ]
    ], 
    '_layout' => [
      'text' => 'Edit Layout', 
      'description' => 'Customize the column widths of the selected layout and set the column order. Changing the layout will reset all customizations.', 
      'type' => 'button-panel', 
      'panel' => 'builder-row-layout', 
      'show' => 'this.node.children.length > 1'
    ], 
    'columns' => [
      'label' => 'Columns', 
      'description' => 'Define a background style or an image of a column and set the vertical alignment for its content.', 
      'type' => 'children'
    ], 
    'column_gap' => [
      'label' => 'Column Gap', 
      'description' => 'Set the size of the gap between the grid columns.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Medium' => 'medium', 
        'Default' => '', 
        'Large' => 'large', 
        'None' => 'collapse'
      ]
    ], 
    'row_gap' => [
      'label' => 'Row Gap', 
      'description' => 'Set the size of the gap between the grid rows.', 
      'type' => 'select', 
      'options' => [
        'Small' => 'small', 
        'Medium' => 'medium', 
        'Default' => '', 
        'Large' => 'large', 
        'None' => 'collapse'
      ]
    ], 
    'divider' => [
      'label' => 'Divider', 
      'description' => 'Show a divider between grid columns.', 
      'type' => 'checkbox', 
      'text' => 'Show dividers', 
      'enable' => 'column_gap != \'collapse\' && row_gap != \'collapse\''
    ], 
    'width' => [
      'label' => 'Max Width', 
      'type' => 'select', 
      'options' => [
        'Default' => 'default', 
        'X-Small' => 'xsmall', 
        'Small' => 'small', 
        'Large' => 'large', 
        'X-Large' => 'xlarge', 
        'Expand' => 'expand', 
        'None' => ''
      ]
    ], 
    'padding_remove_horizontal' => [
      'description' => 'Set the maximum content width. Note: The section may already have a maximum width, which you cannot exceed.', 
      'type' => 'checkbox', 
      'text' => 'Remove horizontal padding', 
      'enable' => 'width && width != \'expand\''
    ], 
    'width_expand' => [
      'label' => 'Expand One Side', 
      'description' => 'Expand the width of one side to the left or right while the other side keeps within the constraints of the max width.', 
      'type' => 'select', 
      'options' => [
        'Don\'t expand' => '', 
        'To left' => 'left', 
        'To right' => 'right'
      ], 
      'enable' => 'width && width != \'expand\''
    ], 
    'height' => [
      'label' => 'Height', 
      'description' => 'Enabling viewport height on a row that directly follows the header will subtract the header\'s height from it.', 
      'type' => 'select', 
      'options' => [
        'None' => '', 
        'Viewport' => 'full', 
        'Viewport (Minus 20%)' => 'percent'
      ]
    ], 
    'margin' => [
      'label' => 'Margin', 
      'type' => 'select', 
      'options' => [
        'Keep existing' => '', 
        'Small' => 'small', 
        'Default' => 'default', 
        'Medium' => 'medium', 
        'Large' => 'large', 
        'X-Large' => 'xlarge', 
        'None' => 'remove-vertical'
      ]
    ], 
    'margin_remove_top' => [
      'type' => 'checkbox', 
      'text' => 'Remove top margin', 
      'enable' => 'margin != \'remove-vertical\''
    ], 
    'margin_remove_bottom' => [
      'description' => 'Set the vertical margin. Note: The first grid\'s top margin and the last grid\'s bottom margin are always removed. Define those in the section settings instead.', 
      'type' => 'checkbox', 
      'text' => 'Remove bottom margin', 
      'enable' => 'margin != \'remove-vertical\''
    ], 
    'match' => [
      'label' => 'Match Height', 
      'description' => 'Match the height of all panel elements which are styled as a card.', 
      'type' => 'checkbox', 
      'text' => 'Match height'
    ], 
    'status' => [
      'label' => 'Status', 
      'description' => 'Disable your row and publish it later. It will only be shown to the editor while the customizer is open.', 
      'type' => 'checkbox', 
      'text' => 'Disable row', 
      'attrs' => [
        'true-value' => 'disabled', 
        'false-value' => ''
      ]
    ], 
    'id' => $config->get('builder.id'), 
    'class' => $config->get('builder.cls'), 
    'attributes' => $config->get('builder.attrs')
  ], 
  'fieldset' => [
    'default' => [
      'type' => 'tabs', 
      'fields' => [[
          'title' => 'Settings', 
          'fields' => ['layout', '_layout', 'columns', 'column_gap', 'row_gap', 'divider', 'width', 'padding_remove_horizontal', 'width_expand', 'height', 'margin', 'margin_remove_top', 'margin_remove_bottom', 'match']
        ], [
          'title' => 'Advanced', 
          'fields' => ['status', 'id', 'class', 'attributes']
        ]]
    ]
  ], 
  'panels' => [
    'builder-row-layout' => [
      'title' => 'Column Layout', 
      'width' => 500, 
      'fields' => [[
          'label' => 'Column 1', 
          'type' => 'group', 
          'divider' => true, 
          'fields' => [[
              'label' => 'Phone Portrait', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 0, 
              'field' => [
                'name' => 'width_default', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options_default')
              ]
            ], [
              'label' => 'Phone Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 0, 
              'field' => [
                'name' => 'width_small', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Tablet Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 0, 
              'field' => [
                'name' => 'width_medium', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Desktop', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 0, 
              'field' => [
                'name' => 'width_large', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Large Screen', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 0, 
              'field' => [
                'name' => 'width_xlarge', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Order First', 
              'type' => 'child-prop', 
              'description' => 'Select the breakpoint from which the column will start to appear before other columns. On smaller screen sizes, the column will appear in the natural order.', 
              'index' => 0, 
              'field' => [
                'name' => 'order_first', 
                'type' => 'select', 
                'options' => $config->get('builder.column_order_first_options')
              ]
            ]]
        ], [
          'label' => 'Column 2', 
          'type' => 'group', 
          'divider' => true, 
          'fields' => [[
              'label' => 'Phone Portrait', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 1, 
              'field' => [
                'name' => 'width_default', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options_default')
              ]
            ], [
              'label' => 'Phone Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 1, 
              'field' => [
                'name' => 'width_small', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Tablet Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 1, 
              'field' => [
                'name' => 'width_medium', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Desktop', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 1, 
              'field' => [
                'name' => 'width_large', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Large Screen', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 1, 
              'field' => [
                'name' => 'width_xlarge', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Order First', 
              'description' => 'Select the breakpoint from which the column will start to appear before other columns. On smaller screen sizes, the column will appear in the natural order.', 
              'type' => 'child-prop', 
              'index' => 1, 
              'field' => [
                'name' => 'order_first', 
                'type' => 'select', 
                'options' => $config->get('builder.column_order_first_options')
              ]
            ]]
        ], [
          'label' => 'Column 3', 
          'type' => 'group', 
          'divider' => true, 
          'fields' => [[
              'label' => 'Phone Portrait', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 2, 
              'field' => [
                'name' => 'width_default', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options_default')
              ]
            ], [
              'label' => 'Phone Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 2, 
              'field' => [
                'name' => 'width_small', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Tablet Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 2, 
              'field' => [
                'name' => 'width_medium', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Desktop', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 2, 
              'field' => [
                'name' => 'width_large', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Large Screen', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 2, 
              'field' => [
                'name' => 'width_xlarge', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Order First', 
              'description' => 'Select the breakpoint from which the column will start to appear before other columns. On smaller screen sizes, the column will appear in the natural order.', 
              'type' => 'child-prop', 
              'index' => 2, 
              'field' => [
                'name' => 'order_first', 
                'type' => 'select', 
                'options' => $config->get('builder.column_order_first_options')
              ]
            ]], 
          'show' => 'this.node.children.length > 2'
        ], [
          'label' => 'Column 4', 
          'type' => 'group', 
          'divider' => true, 
          'fields' => [[
              'label' => 'Phone Portrait', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 3, 
              'field' => [
                'name' => 'width_default', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options_default')
              ]
            ], [
              'label' => 'Phone Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 3, 
              'field' => [
                'name' => 'width_small', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Tablet Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 3, 
              'field' => [
                'name' => 'width_medium', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Desktop', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 3, 
              'field' => [
                'name' => 'width_large', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Large Screen', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 3, 
              'field' => [
                'name' => 'width_xlarge', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Order First', 
              'description' => 'Select the breakpoint from which the column will start to appear before other columns. On smaller screen sizes, the column will appear in the natural order.', 
              'type' => 'child-prop', 
              'index' => 3, 
              'field' => [
                'name' => 'order_first', 
                'type' => 'select', 
                'options' => $config->get('builder.column_order_first_options')
              ]
            ]], 
          'show' => 'this.node.children.length > 3'
        ], [
          'label' => 'Column 5', 
          'type' => 'group', 
          'fields' => [[
              'label' => 'Phone Portrait', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 4, 
              'field' => [
                'name' => 'width_default', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options_default')
              ]
            ], [
              'label' => 'Phone Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 4, 
              'field' => [
                'name' => 'width_small', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Tablet Landscape', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 4, 
              'field' => [
                'name' => 'width_medium', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Desktop', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 4, 
              'field' => [
                'name' => 'width_large', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Large Screen', 
              'description' => 'Set the column width for each breakpoint. Mix fraction widths or combine fixed widths with the <i>Expand</i> value. If no value is selected, the column width of the next smaller screen size is applied. The combination of widths should always take the full width.', 
              'type' => 'child-prop', 
              'index' => 4, 
              'field' => [
                'name' => 'width_xlarge', 
                'type' => 'select', 
                'options' => $config->get('builder.column_width_options')
              ]
            ], [
              'label' => 'Order First', 
              'description' => 'Select the breakpoint from which the column will start to appear before other columns. On smaller screen sizes, the column will appear in the natural order.', 
              'type' => 'child-prop', 
              'index' => 4, 
              'field' => [
                'name' => 'order_first', 
                'type' => 'select', 
                'options' => $config->get('builder.column_order_first_options')
              ]
            ]], 
          'show' => 'this.node.children.length > 4'
        ]]
    ]
  ]
];
