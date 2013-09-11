<?php

function upload_image_file() { // Note: GD library is required for this function

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $img_width = $img_height = 300; // desired image result dimensions
        $img_quality = 90;
        $upload_dir = 'img-cache/';

        if ($_FILES) {

            // if no errors and size less than 250kb
            if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 250 * 1024) {
                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

                    // new unique filename
                    $temp_file_name = $upload_dir . md5(time().rand());

                    // move uploaded file into cache folder
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $temp_file_name);

                    // change file permission to 644
                    @chmod($temp_file_name, 0644);

                    if (file_exists($temp_file_name) && filesize($temp_file_name) > 0) {
                        $aSize = getimagesize($temp_file_name); // try to obtain image info
                        if (!$aSize) {
                            @unlink($temp_file_name);
                            return;
                        }

                        // check for image type
                        switch($aSize[2]) {
                            case IMAGETYPE_JPEG:
                                $file_extension = '.jpg';

                                // create a new image from file 
                                $vImg = @imagecreatefromjpeg($temp_file_name);
                                break;
                            /*case IMAGETYPE_GIF:
                                $file_extension = '.gif';

                                // create a new image from file 
                                $vImg = @imagecreatefromgif($temp_file_name);
                                break;*/
                            case IMAGETYPE_PNG:
                                $file_extension = '.png';

                                // create a new image from file 
                                $vImg = @imagecreatefrompng($temp_file_name);
                                break;
                            default:
                                @unlink($temp_file_name);
                                return;
                        }

                        // create a new true color image
                        $destination_img = @imagecreatetruecolor( $img_width, $img_height );

                        // copy and resize part of an image with resampling
                        imagecopyresampled($destination_img, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $img_width, $img_height, (int)$_POST['w'], (int)$_POST['h']);

                        // define a result image filename
                        $destination_img_file_name = $temp_file_name . $file_extension;

                        // output image to file
                        imagejpeg($destination_img, $destination_img_file_name, $img_quality);
                        @unlink($temp_file_name);

                        return $destination_img_file_name;
                    }
                }
            }
        }
    }
}

$cropped_image = upload_image_file();
echo '<img src="' . $cropped_image . '" />';