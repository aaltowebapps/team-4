<?php

/* Taken from http://www.tizag.com/phpT/fileupload.php
*/

/* troubleshooting
error_reporting(E_ALL); 
ini_set("display_errors", 1);

print_r($_FILES);
*/

// Where the file is going to be placed 
$target_path = "/home/victor/uploads/data/";

/* Add the original filename to our target path.  
Result is "uploads/filename.extension" */
$tmp_name = date('YmdHisu') . '.jpg';
$full_path = $target_path . $tmp_name; 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path)) {

    shell_exec('./process.sh '. $full_path);
    $img =  $target_path . 'b-' . $tmp_name;
    $snd =  $target_path . $tmp_name . '.wav';
    shell_exec('/home/victor/uploads/bw1 -i' . $img . ' -o' . $snd);
    shell_exec('lame ' . $snd);

    $file = $snd . '.mp3';
if (file_exists($file)) {
    shell_exec('rm ' . $img . ' ' . $snd);
    header('Content-Description: File Transfer');
    header('Content-Type: audio/mpeg3');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

} else{
    echo "There was an error uploading the file ".  basename( $_FILES['uploadedfile']['name']). ", please try again!";
}

?>
