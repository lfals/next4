<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            /**
             * @var Config        $config
             * @var ImageProvider $image
             * @var Metadata      $metadata
             */
            list($config, $image, $metadata) = app(Config::class, ImageProvider::class, Metadata::class);

            $getIconOptions = function ($node) use ($image) {

                if (empty($node->props['marker_icon'])) {
                    return [];
                }

                $icon = $node->props['marker_icon'];
                $width = (int) $node->props['marker_icon_width'];
                $height = (int) $node->props['marker_icon_height'];

                if ($icon && $imageObj = $image->create($icon, false)) {

                    if ($width || $height) {
                        $imageObj = $imageObj->thumbnail($width, $height);
                    }

                    $width = $imageObj->getWidth();
                    $height = $imageObj->getHeight();
                    $icon = $image->getUrl("{$icon}#thumbnail={$width},{$height}");

                }

                return [
                    'icon' => $icon ? Url::to($icon) : false,
                    'iconSize' => $width && $height ? [$width, $height] : null,
                    'iconAnchor' => $width && $height ? [$width / 2, $height] : null,
                ];
            };

            $center = [];
            $node->options = [];
            foreach ($node->children as $i => $child) {

                if (empty($child->props['location'])) {
                    continue;
                }

                @list($lat, $lng) = explode(',', $child->props['location']);

                if (!is_numeric($lat) || !is_numeric($lng)) {
                    continue;
                }

                if (empty($center)) {
                    $center = ['lat' => (float) $lat, 'lng' => (float) $lng];
                }

                if (!empty($child->props['hide'])) {
                    continue;
                }

                $options = [
                    'lat' => (float) $lat,
                    'lng' => (float) $lng,
                    'title' => $child->props['title'],
                ] + $getIconOptions($child);

                if (!empty($child->props['show_popup'])) {
                    $options['show_popup'] = true;
                }

                $child->props['show'] = true;
                $node->options['markers'][] = $options;
            }

            // map options
            $node->options += Arr::pick($node->props, ['type', 'zoom', 'min_zoom', 'max_zoom', 'zooming', 'dragging', 'clustering', 'controls', 'styler_invert_lightness', 'styler_hue', 'styler_saturation', 'styler_lightness', 'styler_gamma', 'popup_max_width']);
            $node->options['center'] = $center ?: ['lat' => 53.5503, 'lng' => 10.0006];
            $node->options['lazyload'] = $config('~theme.lazyload', false);
            $node->options += $getIconOptions($node);

            if ($node->props['clustering']) {
                for ($i = 1; $i < 4; $i++) {

                    $icon = $node->props["cluster_icon_{$i}"];
                    $width = $node->props["cluster_icon_{$i}_width"];
                    $height = $node->props["cluster_icon_{$i}_height"];
                    $textColor = $node->props["cluster_icon_{$i}_text_color"];

                    if ($icon) {

                        if ($imageObj = $image->create($icon, false)) {

                            if ($width || $height) {
                                $imageObj = $imageObj->thumbnail($width, $height);
                            }

                            $width = $imageObj->getWidth();
                            $height = $imageObj->getHeight();
                            $icon = $image->getUrl("{$icon}#thumbnail={$width},{$height}");
                        }

                        $node->options['cluster_icons'][] = [
                            'url' => Url::to($icon),
                            'size' => $width && $height ? [$width, $height] : null,
                            'textColor' => $textColor,
                        ];

                    }

                }
            }

            $node->options = array_filter($node->options, function ($value) { return isset($value); });

            // add scripts, styles
            $cdnBase = 'https://cdn.jsdelivr.net/npm';
            if ($key = $config('~theme.google_maps')) {

                $metadata->set('script:google-maps', ['src' => "https://maps.googleapis.com/maps/api/js?key={$key}", 'defer' => true]);

                if ($node->props['clustering']) {
                    $baseUrl = "{$cdnBase}/@googlemaps/markerclustererplus@1.0.3";
                    $metadata->set('script:google-maps-clusterer', ['src' => "{$baseUrl}/dist/index.umd.min.js", 'defer' => true]);

                    if (empty($node->options['cluster_icons'])) {
                        $node->options['cluster_icons'] = "{$baseUrl}/images/m";
                    }
                }

            } else {

                $baseUrl = "{$cdnBase}/leaflet@1.7.1/dist";
                $node->options['baseUrl'] = $baseUrl;
                $metadata->set('script:leaflet', ['src' => "{$baseUrl}/leaflet.js", 'defer' => true]);

                if ($node->props['clustering']) {
                    $baseUrl = "{$cdnBase}/leaflet.markercluster@1.4.1/dist";
                    $node->options['clusterBaseUrl'] = $baseUrl;
                    $metadata->set('script:leaflet-clusterer', ['src' => "{$baseUrl}/leaflet.markercluster.js", 'defer' => true]);
                }
            }

            $metadata->set('script:builder-map', ['src' => Path::get('./app/map.min.js'), 'defer' => true]);
        },

    ],

    'updates' => [

        '1.20.0-beta.1.1' => function ($node) {

            if (isset($node->props['maxwidth_align'])) {
                $node->props['block_align'] = $node->props['maxwidth_align'];
                unset($node->props['maxwidth_align']);
            }

        },

        '1.18.0' => function ($node) {

            if (!isset($node->props['width_breakpoint']) && Arr::get($node->props, 'width_max') === false) {
                $node->props['width_breakpoint'] = true;
            }

        },

    ],

];
