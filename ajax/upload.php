<?php
require(getenv("DOCUMENT_ROOT")."/functions/database.php");
$target_dir = getenv("DOCUMENT_ROOT")."/upload/";
$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
    if($check !== false) {
		
        //echo "File is an image - " . $check["mime"] . ".";

		$uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

if ($_FILES["uploadfile"]["size"] > return_bytes(ini_get('post_max_size'))) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
		$data = file_get_contents($target_file);
        $base64 = 'data:image/' . $imageFileType . ';base64,' . base64_encode($data);

		$stmt = $db->prepare("INSERT INTO images (pid,img) VALUES (:naam,:data)");
		$stmt->execute(
		array(
		':naam' => $_POST[prod], 
		':data' => $base64,
		));	
		echo "<img src='$base64' height='320' alt='' />";
		unlink($target_file);
		//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>