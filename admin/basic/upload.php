<?php

if (isset($_POST['submit'])){


//    echo "<pre>";
//    print_r($_FILES['file_upload']);
//    echo "<pre>";

    $upload_errors = array(

        UPLOAD_ERR_OK => "Image was uploaded successfully ",
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_fileszie',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE',
        UPLOAD_ERR_PARTIAL => "Upload file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file disk.',
        UPLOAD_ERR_EXTENSION =>  "A PHP extension stopped the file upload"

    );
    $temp_name = $_FILES['file_upload']['tmp_name'];
    $the_file = $_FILES['file_upload']['name'];
    $directory = "uploads";


    if (move_uploaded_file($temp_name, $directory . '/' . $the_file)){
        $the_message = "File uploaded successfully";
    }else{

        $the_error = $_FILES['file_upload']['error'];
        $the_message = $upload_errors[$the_error];
    }









}




?>




<form  action="" enctype="multipart/form-data" method="post">

    <h2>
        <?php
            if (!empty($upload_errors)){
                echo $the_message;

            }



        ?>

    </h2>

    <input type="file" name="file_upload"> <br>

    <input type="submit" name="submit">


</form>
