<?php

namespace YOOtheme\Builder;

class OptimizeTransform
{
    /**
     * @var array
     */
    public $props;

    /**
     * Constructor.
     *
     * @param array $props
     */
    public function __construct(array $props = [])
    {
        $this->props = array_flip($props ?: [
            'animation',
            'block_align_breakpoint',
            'block_align_fallback',
            'block_align',
            'button_size',
            'button_style',
            'cls',
            'content_display',
            'content_margin',
            'content_style',
            'content_transition',
            'css',
            'filter_grid_column_gap',
            'filter_grid_row_gap',
            'filter_margin',
            'grid_column_gap',
            'grid_large',
            'grid_row_gap',
            'grid_small',
            'grid_xlarge',
            'icon_color',
            'id',
            'image_border',
            'image_box_decoration',
            'image_box_shadow',
            'image_effect',
            'image_grid_column_gap',
            'image_grid_row_gap',
            'image_height',
            'image_hover_box_shadow',
            'image_margin',
            'image_parallax_bgx_end',
            'image_parallax_bgx_start',
            'image_parallax_bgy_end',
            'image_parallax_bgy_start',
            'image_parallax_breakpoint',
            'image_parallax_easing',
            'image_size',
            'image_transition',
            'image_width',
            'item_animation',
            'item_maxwidth',
            'layout',
            'link_margin',
            'link_size',
            'link_style',
            'link_target',
            'link_transition',
            'list_style',
            'margin',
            'maxwidth_breakpoint',
            'maxwidth',
            'media_background',
            'media_blend_mode',
            'media_breakpoint',
            'media_overlay_gradient',
            'media_position',
            'media_visibility',
            'meta_color',
            'meta_margin',
            'meta_style',
            'meta_transition',
            'overlay_image',
            'overlay_margin',
            'overlay_maxwidth',
            'overlay_padding',
            'overlay_style',
            'panel_content_padding',
            'panel_content_width',
            'panel_size',
            'panel_style',
            'parallax_breakpoint',
            'parallax_easing',
            'parallax_opacity_end',
            'parallax_opacity_start',
            'parallax_rotate_end',
            'parallax_rotate_start',
            'parallax_scale_end',
            'parallax_scale_start',
            'parallax_viewport',
            'parallax_x_end',
            'parallax_x_start',
            'parallax_y_end',
            'parallax_y_start',
            'position_bottom',
            'position_left',
            'position_right',
            'position_top',
            'position_z_index',
            'position',
            'style',
            'text_align_breakpoint',
            'text_align_fallback',
            'text_align_justify_fallback',
            'text_align_justify',
            'text_align',
            'text_color',
            'text_size',
            'text_style',
            'title_color',
            'title_decoration',
            'title_display',
            'title_font_family',
            'title_grid_column_gap',
            'title_grid_row_gap',
            'title_margin',
            'title_style',
            'title_transition',
            'video_height',
            'video_width',
            'visibility',

            // Section / Row / Column
            'column',
            'column_gap',
            'header_overlay',
            'header_transparent',
            'height',
            'padding',
            'row_gap',
            'vertical_align',
            'width_expand',
            'width',
        ]);
    }

    /**
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params)
    {
        /**
         * @var $type
         */
        extract($params);

        $defaults = isset($type->defaults) ? $type->defaults : [];
        $properties = array_diff_key($node->props, $defaults);

        foreach (array_intersect_key($properties, $this->props) as $name => $value) {

            // remove empty prop
            if ($value === '') {
                unset($node->props[$name]);
            }

        }

        // remove empty props
        if (empty($node->props)) {
            unset($node->props);
        }
    }
}
