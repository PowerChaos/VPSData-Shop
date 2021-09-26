<?php
$db = new Db;
$target_dir = getenv("DOCUMENT_ROOT") . "/upload/";
$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
if ($check !== false) {

    //echo "File is an image - " . $check["mime"] . ".";

    $uploadOk = 1;
} else {
    echo "File is not an image<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded, see error.<br>";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
        $data = file_get_contents($target_file);
        $base64 = 'data:image/' . $imageFileType . ';base64,' . base64_encode($data);
        $upload = array(
            "pid"         => $_POST['prod'],
            "img"     => $base64
        );
        $db->insert("images", $upload);
        echo "Success";
        unlink($target_file);
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}