<?php 

require_once("../../../includes/initialize.php");

?>

<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Image Cropper and Uploader &middot; <?php echo WEB_APP_NAME; ?></title>

        <!-- add styles -->
        <link href="css/main.css" rel="stylesheet" type="text/css" />
        <link href="css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />

        <!-- add scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.Jcrop.min.js"></script>
        <script src="js/script.js"></script>
    </head>
    <body>

        <div class="demo">
            <div class="bheader"><h2>Image Upload Form</h2></div>
            <div class="bbody">

                <!-- upload form -->
                <form id="upload_form" enctype="multipart/form-data" method="post" action="upload.php" onsubmit="return checkForm()">
                    <!-- hidden crop params -->
                    <input type="hidden" id="x1" name="x1" />
                    <input type="hidden" id="y1" name="y1" />
                    <input type="hidden" id="x2" name="x2" />
                    <input type="hidden" id="y2" name="y2" />

                    <h2>Step 1: Please select an image file</h2>
                    <div><input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" /></div>

                    <div class="error"></div>

                    <div class="step2">
                        <h2>Step 2: Please select a crop region</h2>
                        <img id="preview" />

                        <div class="info">
                            <label>File size</label> <input type="text" id="filesize" name="filesize" />
                            <label>Type</label> <input type="text" id="filetype" name="filetype" />
                            <label>Image dimension</label> <input type="text" id="filedim" name="filedim" />
                            <label>W</label> <input type="text" id="w" name="w" />
                            <label>H</label> <input type="text" id="h" name="h" />
                        </div>

                        <input type="submit" value="Upload" />
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>