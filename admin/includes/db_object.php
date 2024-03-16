<?php


class Db_object{


    public static function find_all(){
        global $database;

//            $result_set = $database->query("SELECT * FROM users");
//            return $result_set;

        return static::find_by_query("SELECT * FROM ".  static::$db_table ." ");
    }


    public static function find_by_id($id){

        global $database;

//            $by_id = $database->query("SELECT * FROM users WHERE id = $id");

//            $by_id = static::find_by_query("SELECT * FROM users WHERE  id = $id");

//            $found_user = mysqli_fetch_array($by_id);
//            return $found_user;


        $the_result_array = static::find_by_query("SELECT * FROM ". static::$db_table ."  WHERE  id = $id");

        //            ******Alternative with ternary******


        return !empty($the_result_array) ? array_shift($the_result_array) : false;

//
//            if (!empty($the_result_array)){
//                $first_item = array_shift($the_result_array);
//                return $first_item;
//            }else{
//                return false;
//            }

    }

    public static function find_by_query($sql){
        global $database;
        $result_set = $database->query($sql);

        $the_object_array = array();

        while($row = mysqli_fetch_array($result_set)){

            $the_object_array[] = static::instantation($row);
        }

        return $the_object_array;
    }

    public static function instantation($the_record){

        $calling_class = get_called_class();

        $the_object  = new $calling_class;

//            $the_object->id = $found_user['id'];
//            $the_object->username = $found_user['username'];
//            $the_object->first_name = $found_user['first_name'];
//            $the_object->last_name = $found_user['last_name'];
//            $the_object->password = $found_user['password'];


        foreach ($the_record as $the_attribute => $value){

            if ($the_object->has_the_attribute($the_attribute)){
                $the_object->$the_attribute = $value;

            }

        }

        return $the_object;


    }

    private function has_the_attribute($the_attribute){
        $object_properties = get_object_vars($this);

        return array_key_exists($the_attribute, $object_properties);

    }


    protected function properties(){

        $properties = array();

        foreach (static::$db_table_fields as $db_filed ){
            if (property_exists($this, $db_filed)){
                $properties[$db_filed] = $this->$db_filed;
            }
        }
        return $properties;
    }



    protected function clean_properties(){
        global $database;

        $clean_properties = array();

        foreach ($this->properties() as $key => $value){
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;

    }



    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create(){
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " . static::$db_table . "(". implode(",", array_keys($properties)) .")";
        $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";


        if($database->query($sql)){
            $this->id = $database->the_insert_id();

            return true;
        }else{
            return false;
        }
    }//creat Method

    public function update(){
        global $database;
        $properties = $this->clean_properties();
        $properties_pairs = array();

        foreach ($properties as $key => $value){
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "Update ". static::$db_table. " SET ";
        $sql .= implode(",", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    }

    public function delete(){
        global $database;

        $sql = "DELETE FROM. " . static::$db_table ." ";
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }




}

?>