<?php
$datMen = null;

if (file_exists("models/mcofpag.php")) {
    require_once("models/mcofpag.php");
    if (class_exists("mCofpag")) {
        $mcofpag = new mCofpag();
        $datMen = $mcofpag->getMen();
    }
}
?>