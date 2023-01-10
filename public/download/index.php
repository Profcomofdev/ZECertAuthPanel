<?php
if (isset($_GET["name"])){
    $filename = getcwd() . '/../../pssl/exp/' . $_GET["name"] . '.p12';
    if(file_exists($filename)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Length: ' . filesize($filename));
        header('Pragma: public');
        flush();
        readfile($filename);
        die();
    }else{
        echo "File does not exist.";
    }
}else{
    echo "Not set";
}