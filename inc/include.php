<?php
spl_autoload_register(function ($class_name) {
	 $parts = explode('\\', $class_name);
    $class =  end($parts);
     require_once(getenv("DOCUMENT_ROOT")."/inc/classes/{$class}.class.php");
});
?>