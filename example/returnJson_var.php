<?php
/**
 * If returnType is set as json and typeJson is set as json_var, the json will be returned in form of a string.
 * It can also be decoded in order to make it an Object.
 */


include'../fileManager.php';
$manager = new fileManager();
$manager->extension = array('txt','jpg','png');
$manager->fileDeny = array('.','..');
$manager->returnType = 'json';
$manager->typeJson = "json_var";
$json = $manager->initFileManager('example/');

echo $json;

$json = json_decode($json);
var_dump($json);
?>