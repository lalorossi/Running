<?php


if(empty($_POST['fileToUpload'])){

    $target_dir = "uploads/";
    $_FILES["fileToUpload"]["name"] = str_replace(" ", "_", $_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $FileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Allow certain file formats
    if($FileType != "gpx") {
        echo "Solo se permiten GPX";
        $uploadOk = 0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "No se puedo subir el archivo";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            $name = basename( $_FILES["fileToUpload"]["name"]);
            header("Location: crear_tablas.php/?f=$name");
        } else {
            echo "Hubo un error al subir el archivo";
        }
    }   
}else{
    $name = $_POST['fileToUpload'];
    header("Location: crear_tablas.php/?f=$name");
}
?>