<?php
require_once 'classes/Extractor.php';

$extractorsMap = array(
    'utv.unistra.fr'=>'UnistraIE'
); 

function __autoload($class_name) {
    include 'extractors/'.$class_name.'.php';
}

?>
