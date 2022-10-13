<?php 
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: *");
//  Depending of the method, is what will be done.
    if($_POST["action"] == "upload_file"){
        $filename = $_POST['filename'];
        if(!file_exists('../Files')){
            mkdir('../Files',0777, true);
        }
        $target_directory = "../Files/";
        $target_file = $target_directory.basename($_FILES["file"]["name"]);   
        $filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $newfilename = $target_directory.$filename.".".$filetype;
        if(move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename)){
            echo json_encode($filename.".".$filetype);
        }
        else echo json_encode('error');
    }

    if($_POST["action"] == "fetch_files"){
        $file_data = scandir($_POST["folder_name"]);
        $imgExtensions = array('jpg', 'jpeg', 'png', 'gif');
        $vidExtensions = array('mp4');
        $objExtensions = array('gltf','glb');
        $file_type = '';
        $fl_type = '';
        $output = '
            <div class="row row-cols-1 row-cols-md-3 g-4">
        ';
        foreach($file_data as $file){
            if($file == '.' OR $file == '..') continue;
            else{
                $output .= '
                <div class="col">
                    <div class="card h-100 text-center">';
                $path = 'Files/'.$file;
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                if(in_array($extension, $imgExtensions)){
                    $fl_type = 'img';
                    $file_type = 'Imagen';
                    $output .= '
                        <img src="'.$path.'" class="card-img-top" alt="imagen">';
                }
                if(in_array($extension, $vidExtensions)){
                    $fl_type = 'video';
                    $file_type = 'Video';
                    $output .= '
                        <div class="ratio ratio-16x9">
                            <video controls>
                                <source src="'.$path.'" type="video/mp4">
                                Tu navegador no soporta la etiqueta video.
                            </video>
                        </div>';
                }
                if(in_array($extension, $objExtensions)){
                    $file_type = 'Objeto 3D';
                    $fl_type = '3DObj';
                    $output .= '
                    <div id="div3D">
                        <model-viewer 
                            src="'.$path.'"
                            camera-controls 
                            auto-rotate 
                            disable-zoom>
                        </model-viewer>
                    </div>';
                }
                $output .= '
                        <div class="card-body">
                            <h5 class="card-title">Archivo: '.$file_type.'</h5>
                            <button 
                                name="select_file" 
                                type="button" 
                                class="select_file btn btn-primary" 
                                id="'.$path.'"
                                value="'.$fl_type.'">
                            Seleccionar</button>
                        </div>
                    </div>
                </div>';
            }
        }
        $output .= '
            </div>';
        echo $output;
    }
?>