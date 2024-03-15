<?php

class Photo extends Db_object
{

    protected static $db_table = "photos";
    protected static $db_table_fields = array('title', 'description', 'filename', 'type', 'size');
    public $id;
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;

    public $temp_path;
    public $upload_directory = "images";
    public $errors = array();
    public $upload_error_array = array(

        UPLOAD_ERR_OK => "Image was uploaded successfully ",
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_fileszie',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE',
        UPLOAD_ERR_PARTIAL => "Upload file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file disk.',
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload"

    );


//    // This is passing $_FILES['uploaded_file'] as an argument
    public function set_file($file){

        if (empty($file) || $file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded";
            return false;

        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_error_array[$file['error']];
            return false;

        } else {
            $this->filename = basename($file['name']);
            $this->temp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];

        }
    }


    public function save(){
        if ($this->id) {
            $this->update();

        } else {
            if (!empty($this->errors)) {
                return false;
            }
            if (empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "this file was not available";
            }

           $target_path =  SITE_ROOT . DS . 'admin' . DS . $this->upload_directory. DS . $this->filename ;

            if (file_exists($target_path)){
                $this->errors[] = "The file {$this->filename} already exist";
                return false;
            }


            $this->create();

        }
    }
























}


?>