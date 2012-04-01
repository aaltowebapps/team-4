<?php
$file = 'snd.mp3';

if (file_exists($file)) {
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
?>
