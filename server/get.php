<?PHP

$file = $_GET["fname"];
$move = $_GET["move"];

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: image/jpeg');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    if (readfile($file) && $move && strpos($file, "stock") === false && strpos($file, "used") === false) {
       copy($file, "uploads/used/" . basename($file));
       unlink($file);
    }
    exit;
} else {
    echo $file . " not found";
}
?>
