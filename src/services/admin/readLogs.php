<?php
session_start();
if ((isset($_SESSION['connecter'] )) && ($_SESSION['connecter'] == true)) {
    $file = '../../../log/app.log';
    var_dump($file);
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/log');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        var_dump($file);

        exit;
    }
} else {
    header("connect.php");
    session_destroy();
}
?>