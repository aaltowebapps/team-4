<?php

// Where the file is going to be placed 
$target_path = "/var/www/uploads/data/";

$tmp_name = date('YmdHisu') . '.png';
$full_path = $target_path . $tmp_name; 

$data = $_POST["uploadedfile"];
$pos = strpos($data, ',');
$data = substr( $data, $pos + 1 );
// $data = str_replace(' ','+', $data);
$decodata = base64_decode($data);

if(file_put_contents( $full_path, $decodata )) {

    $img =  $full_path;
    $snd =  $full_path . '.wav';
    shell_exec('/var/www/uploads/bw1 -n -i' . $img . ' -o' . $snd);
    shell_exec('lame --quiet ' . $snd);

    $file = $snd . '.mp3';
    if (file_exists($file)) {
       shell_exec('rm ' . $snd);
       $s = "/uploads/data/" . $tmp_name . '.wav.mp3';
       $i = "";
       echo " {\"snd\":\"".$s."\",\"img\":\"".$i."\"} ";
    }

} else{
    header("HTTP/1.0 500 Internal Server Error");
    echo "There was an error uploading the image";
}

?>
