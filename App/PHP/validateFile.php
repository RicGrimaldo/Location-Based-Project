<?php 
    $filename = $_POST['filename'];
    $target_directory = "../Files/";
    $target_file = $target_directory.basename($_FILES["file"]["name"]);   
    $filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $newfilename = $target_directory.$filename.".".$filetype;
    if(move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename)){
        echo json_encode('success');
    }
?>