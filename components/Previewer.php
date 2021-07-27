<?php

namespace Components;

class Previewer {
    
    /**
     * 
     * @param type $picUrl
     * @param type $picId
     * @return string preview file name;
     */
    public static function makePreviewFromPicUrlAndId($picUrl, $picId) {
        $pathParts = pathinfo($picUrl);
        $imageExtension = $pathParts['extension'];

        $size = getimagesize($picUrl);

        $w = $size[0];
        $h = $size[1];

        $nw = \Components\Config::get('pic_column_image_width_max');
        $koef = $nw / $w;
        $nh = round($h * $koef);

        switch (mb_strtolower($imageExtension)) {
            case 'gif':
                $simg = imagecreatefromgif($picUrl);
                break;
            case 'jpg':
                $simg = imagecreatefromjpeg($picUrl);
                break;
            case 'png':
                $simg = imagecreatefrompng($picUrl);
                break;
        }

        $dimg = imagecreatetruecolor($nw, $nh);
        $wm = $w / $nw;
        $hm = $h / $nh;
        $h_height = $nh / 2;
        $w_height = $nw / 2;

        if ($w > $h) {
            $adjusted_width = $w / $hm;
            $half_width = $adjusted_width / 2;
            $int_width = $half_width - $w_height;
            imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
        } elseif (($w < $h) || ($w == $h)) {
            $adjusted_height = $h / $wm;
            $half_height = $adjusted_height / 2;
            $int_height = $half_height - $h_height;

            imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
        } else {
            imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $nw, $nh, $w, $h);
        }
        $imageFileName = bin2hex(random_bytes(10)) . '_' . $picId . '.jpg';
        $destination = ROOT . '/'.\Components\Config::get('folders')['pic_previews'].'/' . $imageFileName;
        return imagejpeg($dimg, $destination, 100) ? $imageFileName : \Components\Config::get('pic_preview_error_filename');
    }

}
