<?php

/*
<!#CR>
************************************************************************************************************************
*                                                    Copyrigths ©                                                      *
* -------------------------------------------------------------------------------------------------------------------- *
*          Authors Names    > PowerChaos                                                                               *
*          Company Name     > VPS Data                                                                                 *
*          Company Email    > info@vpsdata.be                                                                          *
*          Company Websites > https://vpsdata.be                                                                       *
*                             https://vpsdata.shop                                                                     *
*          Company Socials  > https://facebook.com/vpsdata                                                             *
*                             https://twitter.com/powerchaos                                                           *
*                             https://instagram.com/vpsdata                                                            *
* -------------------------------------------------------------------------------------------------------------------- *
*                                           File and License Informations                                              *
* -------------------------------------------------------------------------------------------------------------------- *
*          File Name        > <!#FN> Db.class.php </#FN>                                                               
*          File Birth       > <!#FB> 2021/09/02 09:22:29.967 </#FB>                                                    *
*          File Mod         > <!#FT> 2021/09/18 03:35:58.925 </#FT>                                                    *
*          License          > <!#LT> CC-BY-NC-ND-4.0 </#LT>                                                            
*                             <!#LU> https://spdx.org/licenses/CC-BY-NC-ND-4.0.html </#LU>                             
*                             <!#LD> This file may not be redistributed in whole or significant part. </#LD>           
*          File Version     > <!#FV> 2.0.0 </#FV>                                                                      
*                                                                                                                      *
</#CR>
*/





class Db extends PDO {
    private $error;
    private $sql;
    private $bind;
    private $errorCallbackFunction;
    private $errorMsgFormat;

public function __construct($dsn='mysql:host='.Config::DB_HOST.';dbname='.Config::DB_DATA.'', $user=Config::DB_USER, $passwd=Config::DB_PASS, $options=array()) {
    $this->session = new Session;
/* Hard coded sql connectie voor database
*  Gebruik $db = new db ( connectie,gebruiker, wachtwoord ) voor andere database connectie
*/       
	   if(empty($options)){
            $options = array(
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES => false,
            );
        }

        try {
            parent::__construct($dsn, $user, $passwd, $options);
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
            return false;
        }
    }
/* einde verbinding maken */
	
    private function debug() {
        if(!empty($this->errorCallbackFunction)) {
            $error = array("Error" => $this->error);
            if(!empty($this->sql))
                $error["SQL Statement"] = $this->sql;
            if(!empty($this->bind))
                $error["Bind Parameters"] = trim(print_r($this->bind, true));

            $backtrace = debug_backtrace();
            if(!empty($backtrace)) {
                foreach($backtrace as $info) {
                    if(isset($info["file"] ) && $info["file"] != __FILE__)
                        $error["Backtrace"] = $info["file"] . " at line " . $info["line"];
                }
            }

            $msg = "";
            if($this->errorMsgFormat == "html") {
                if(!empty($error["Bind Parameters"]))
                    $error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
                $css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
                $msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
                $msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
                foreach($error as $key => $val)
                    $msg .= "\n\t<label>" . $key . ":</label>" . $val;
                $msg .= "\n\t</div>\n</div>";
            }
            elseif($this->errorMsgFormat == "text") {
                $msg .= "SQL Error\n" . str_repeat("-", 50);
                foreach($error as $key => $val)
                    $msg .= "\n\n$key:\n$val";
            }

            $func = $this->errorCallbackFunction;
            $func($msg);
        }
    }
/* einde Debug info */

/* Delete Functie */
    public function delete($table, $where, $bind="") {
        $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
        return $this->run($sql, $bind);
    }

/* Filter Functie */	
    private function filter($table, $info) {
        $driver = $this->getAttribute(PDO::ATTR_DRIVER_NAME);
        if($driver == 'sqlite') {
            $sql = "PRAGMA table_info('" . $table . "');";
            $key = "name";
        }
        elseif($driver == 'mysql') {
            $sql = "DESCRIBE " . $table . ";";
            $key = "Field";
        }
        else {
            $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
            $key = "column_name";
        }

        if(false !== ($list = $this->run($sql))) {
            $fields = array();
            foreach($list as $record)
                $fields[] = $record[$key];
           return array_values(array_intersect($fields, array_keys($info)));
        }
        return array();
    }

/* Bind Release functie */
    private function cleanup($bind) {
        if(!is_array($bind)) {
            if(!empty($bind))
                $bind = array($bind);
            else
                $bind = array();
        }
		foreach($bind as $key => $val)
			$bind[$key] = stripslashes($val);
        return $bind;
    }

/* Insert Statement Functie */	
    public function insert($table, $info) {
        $fields = $this->filter($table, $info);
        $sql = "INSERT INTO " . $table . "(".implode(",",$fields).") VALUES (:".implode(",:",$fields).");";
        $bind = array();
        foreach($fields as $field)
            $bind[":$field"] = $info[$field];
        return $this->run($sql, $bind);
    }

/* Uitvoer Functie */	
    public function run($sql, $bind="", $option="") {
        $this->sql = trim($sql);
        $this->bind = $this->cleanup($bind);
        $this->error = "";

        try {
            $pdostmt = $this->prepare($this->sql);
            if(($pdostmt->execute($this->bind) !== false) && ($option == "")) {
                if(preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql))
                    return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
                elseif(preg_match("/^(" . implode("|", array("delete", "insert", "update")) . ") /i", $this->sql))
                    return $pdostmt->rowCount();
            }
			 elseif(($pdostmt->execute($this->bind) !== false) && ($option != "")) {
/* Extra opties na bind functie */
				 switch ($option)
				 {
					case "rowcount":
					 return $pdostmt->rowCount();
					 break;
					case "fetch":
					 return $pdostmt->fetch(PDO::FETCH_ASSOC);
					 break;
                     case "fetchall":
                    return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
                    break;
				 }
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->debug();
            return false;
        }
    }

/* Select Functie met extra opties en Fields */	
    public function select($table, $where="",$limit="", $bind="", $option="", $fields="*",$group="",$order="") {
        $sql = "SELECT " . $fields . " FROM " . $table;
        if(!empty($where))
            $sql .= " WHERE " . $where;
		if(!empty($limit))
            $sql .= " LIMIT " . $limit;
        if(!empty($group))
            $sql .= "GROUP BY (" . $group . ")";
        if(!empty($order))
            $sql .= "ORDER BY" . $order;
        $sql .= ";";
        return $this->run($sql, $bind, $option);
    }

/* Error Return functie */
    public function setErrorCallbackFunction($errorCallbackFunction="echo", $errorMsgFormat="html") {
        //Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
        if(in_array(strtolower($errorCallbackFunction), array("echo", "print")))
            $errorCallbackFunction = "print_r";

        if(function_exists($errorCallbackFunction)) {
            $this->errorCallbackFunction = $errorCallbackFunction;
            if(!in_array(strtolower($errorMsgFormat), array("html", "text")))
                $errorMsgFormat = "html";
            $this->errorMsgFormat = $errorMsgFormat;
        }
    }

/* Update Functie */	
    public function update($table, $info, $where, $bind="") {
        $fields = $this->filter($table, $info);
        $fieldSize = sizeof($fields);

        $sql = "UPDATE " . $table . " SET ";
        for($f = 0; $f < $fieldSize; ++$f) {
            if($f > 0)
                $sql .= ", ";
            $sql .= $fields[$f] . " = :update_" . $fields[$f];
        }
        $sql .= " WHERE " . $where . ";";

        $bind = $this->cleanup($bind);
        foreach($fields as $field)
            $bind[":update_$field"] = $info[$field];

        return $this->run($sql, $bind);
    }
    //ajax edit
    function ajaxedit($table,$waarde,$split)
    {
    $split_data = explode(':', $split);
    $id = $split_data[1];
    $field = $split_data[0];
    $bind = array(':id' => $id);
    $update = array($field => $waarde);
    $this->update($table,$update,"id = :id",$bind);
    return $this->session->flashdata('error','field '.$field.' from '.$table.' updated to new value :\n\n '.$waarde);
    }
}   
	?>	
