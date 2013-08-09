<?php

include'../fileManager.php';
$manage = new fileManager();

/** It is used for deleting a directory.
 * If there is a read only file in the directory, this directory can not be deleted.
 * Fot its writability is set to false. It is better to check whether files within the directory are writable or not before deleting the directory.
 */

/*
if($manage->recursiveDelete("../DirName"))
{
    echo "Delete directory";
}
*/

/** It is used for copying a directory
 * Copying a directory into other directories
 * $manage->copy_directory('../source','../destination');
 */

/** It is used for renaming a directory
 * If there is a read only file in oldDir, there will be created a new directory named newDir.
 * It also gives an error. So it is better to check whether files within oldDir are writable or not before renaming the directory.
 * The directories can also be moved by the rename function.
 */

/*
if($manage->rename_directory('../oldDir','../newDir'))
{
    echo "Rename directory";
}
*/

/** It is used for moving a directory.
 * If there is a read only file in the directory you want to move, the directory will be created in newDirectory but the previous location remains the same yet.
 */

/*
if(@$manage->move_dir('../Location','../newLocation'))
{
    echo 'OK move';
}
*/

// zip and extract
/*
if($manage->create_zip('../folderName','../zipFileName'))
{
    echo "Zip directory";
}
if($manage->extract_zip('../zipFileName.zip','../pasteLocation'))
{
    echo "Extract zip";
}
*/

// convert byte to KB, MB, GB
/*
$byte = 120000;
echo $manage->change_size($byte,'mb');
*/

// create Link from file and folder
/*
$link = $manage->linkPath('../dirNmae');
echo $link;
*/

/**
 * change date
 * In order to make the date more user friendly: for example: 2 days ago or 1 year ago
 */

/*
echo $manage->change_date_format(20130714092326);
*/
?>