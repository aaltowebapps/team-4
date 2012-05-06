<?php

/* troubleshooting
error_reporting(E_ALL); 
ini_set("display_errors", 1);

print_r($_FILES);
*/

// Where the file is going to be placed 
$target_path = "/var/www/uploads/data/";

/* Add the original filename to our target path.  
Result is "uploads/filename.extension" */
$tmp_name = date('YmdHisu') . '.jpg';
$full_path = $target_path . $tmp_name; 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path)) {

    if (!empty($_POST["simplify"]) && $_POST["simplify"] == "yes") {
       shell_exec('./process.sh '. $full_path);
    } else {
       shell_exec('./resize.sh '. $full_path);
    }
    $img =  $target_path . 'b-' . $tmp_name;

    if (!empty($_POST["negate"]) && $_POST["negate"] == "yes") {
       shell_exec('./negate.sh '. $img);
    }

    $snd =  $target_path . $tmp_name . '.wav';
    shell_exec('/var/www/uploads/bw1 -i' . $img . ' -o' . $snd);
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/Opera/i',$ua) || preg_match('/Firefox/i',$ua))
    {
       shell_exec('oggenc -Q ' . $snd); 
       $file =  $target_path . $tmp_name . '.ogg';
       $s = "/uploads/data/" . $tmp_name . '.ogg';
    } else {
       shell_exec('lame --quiet ' . $snd);
       $file = $snd . '.mp3';
       $s = "/uploads/data/" . $tmp_name . '.wav.mp3';
    }

    if (file_exists($file)) {
       shell_exec('rm ' . $snd);
       $i = "/uploads/data/b-" . $tmp_name;
       echo " {\"snd\":\"".$s."\",\"img\":\"".$i."\",\"ua\":\"".$ua."\"} ";
    }

} else{
    header("HTTP/1.0 413 Request Entity Too Large");
    echo "There was an error uploading the file ".  basename( $_FILES['uploadedfile']['name']). ", please try again!";
}

?>
