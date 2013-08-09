<?php
/**
 * When returnType is set as json and typeJson is set as json_file, a json file will be returned.
 * This file is mostly used by JAVA, AS3 and other programmers.
 */

include'../fileManager.php';
$manager = new fileManager();
$manager->extension = array('txt','jpg','png');
$manager->fileDeny = array();
$manager->returnType = 'json';
$manager->typeJson = "json_file";
$json = $manager->initFileManager('example/');
echo $json;
?>