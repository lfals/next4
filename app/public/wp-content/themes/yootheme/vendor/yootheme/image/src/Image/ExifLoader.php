<?php

namespace YOOtheme\Image;

use YOOtheme\Image;

class ExifLoader
{
    public function __invoke(Image $image)
    {
        if ($image->getType() === 'jpeg' && is_callable('exif_read_data')) {

            // read exif data
            $exif = @exif_read_data($image->getFile());

            // set exif attribute
            $image->setAttribute('exif', $exif ?: []);

            // check orientation and rotate it if needed
            if (isset($exif['Orientation']) && !$image->getAttribute('resource')) {
                switch($exif['Orientation']) {
                    case 2:
                        $image = $image->flip(true, false);
                        break;
                    case 3:
                        $image = $image->flip(true, true); // rotate 180
                        break;
                    case 4:
                        $image = $image->flip(false, true);
                        break;
                    case 5:
                        $image = $image->rotate(90)->flip(false, true);
                        break;
                    case 6:
                        $image = $image->rotate(270);
                        break;
                    case 7:
                        $image = $image->rotate(90)->flip(true, false);
                        break;
                    case 8:
                        $image = $image->rotate(90);
                        break;
                }
            }

            return $image;
        }
    }
}
