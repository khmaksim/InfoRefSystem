<?php          
    function resizeImage($scope, $max_width, $max_height, $source_file_name, $file_ext, $destination_file_name = false) {
        $max_width = ($max_width == 0) ? 10000 : $max_width;
        $max_height = ($max_height == 0) ? 10000 : $max_height;

        $source_img = './' . $scope . '/' . $source_file_name . '.' . $file_ext;
        $destination_img = ($destination_file_name) ? './' . $scope . '/' . $destination_file_name . '.' . $file_ext : $source_img;

        $getimg_w_h = GetImageSize($source_img);
        $x_ratio = $max_width / $getimg_w_h[0];
        $y_ratio = $max_height / $getimg_w_h[1];

        if (($getimg_w_h[0] <= $max_width) && ($getimg_w_h[1] <= $max_height)) {
            $tn_width = $getimg_w_h[0];
            $tn_height = $getimg_w_h[1];
        } else if (($x_ratio * $getimg_w_h[1]) < $max_height) {
            $tn_height = ceil($x_ratio * $getimg_w_h[1]);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $getimg_w_h[0]);
            $tn_height = $max_height;
        }

        // Если делать полную заливку тогда размеры подгоняем по максимальным
        $dst_x = ($max_width - $tn_width) / 2;
        $dst_y = ($max_height - $tn_height) / 2;

        if ($file_ext == "jpg" || $file_ext == "jpeg") {
            $source_img = ImageCreateFromJpeg($source_img);
            $dst = ImageCreateTrueColor($max_width, $max_height);
            $while = imagecolorallocate($dst, 255, 255, 255);
            ImageFilledRectangle($dst, 0, 0, $max_width, $max_height, $while);

            ImageCopyResampled($dst, $source_img, $dst_x, $dst_y, 0, 0, $tn_width, $tn_height, $getimg_w_h[0], $getimg_w_h[1]);

            ImageJpeg($dst, $destination_img, 100);

            ImageDestroy($source_img);
            ImageDestroy($dst);
        } else if ($file_ext == "png") {
            $source_img = ImageCreateFromPng($source_img);
            $dst = ImageCreateTrueColor($max_width, $max_height);

            // enable alpha blending on the destination image.
            imagealphablending($dst, true);

            // Allocate a transparent color and fill the new image with it.
            // Without this the image will have a black background instead of being transparent.
            $transparent = imagecolorallocatealpha( $dst, 0, 0, 0, 127 );
            imagefill( $dst, 0, 0, $transparent );
            imagesavealpha( $dst, true );

            ImageCopyResampled($dst, $source_img, $dst_x, $dst_y, 0, 0, $tn_width, $tn_height, $getimg_w_h[0], $getimg_w_h[1]);

            ImagePng($dst, $destination_img);

            ImageDestroy($source_img);
            ImageDestroy($dst);
        } else if ($file_ext == "gif") {
            $source_img = ImageCreateFromGif($source_img);
            $dst = ImageCreateTrueColor($max_width, $max_height);

            // enable alpha blending on the destination image.
            imagealphablending($dst, true);

            // Allocate a transparent color and fill the new image with it.
            // Without this the image will have a black background instead of being transparent.
            $transparent = imagecolorallocatealpha( $dst, 0, 0, 0, 127 );
            imagefill( $dst, 0, 0, $transparent );
            imagesavealpha( $dst, true );

            ImageCopyResampled($dst, $source_img, $dst_x, $dst_y, 0, 0, $tn_width, $tn_height, $getimg_w_h[0], $getimg_w_h[1]);

            ImageGif($dst, $destination_img);

            ImageDestroy($source_img);
            ImageDestroy($dst);
        } else {
            copy($source_img, $destination_img);
        }
    }