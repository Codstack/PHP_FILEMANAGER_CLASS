<?php
include'../fileManager.php';
$manager = new fileManager();
$manager->extension = array('txt','jpg','png');
$manager->fileDeny = array('New folder', '.', '..');
$manager->returnType = 'array';
$array = $manager->initFileManager('example/');// Put a "/" after the name of directory

if($array['Status']['Error'] == "NO")
{
    if(!empty($array['Files']))
    {
       for ($i = 0;$i < sizeof($array['Files']); $i++) //With for loop
        {
            echo $array['Files'][$i]['name'].'<br>';
            echo $array['Files'][$i]['directory'].'<br>';
            echo $array['Files'][$i]['link'].'<br>';
            echo $array['Files'][$i]['size'].'<br>';
            echo $array['Files'][$i]['extension'].'<br>';
            echo $array['Files'][$i]['writeable'].'<br>';
            echo $array['Files'][$i]['readable'].'<br>';
            echo $array['Files'][$i]['time_created'].'<br>';
            echo $array['Files'][$i]['last_accesed'].'<br>';
            echo $array['Files'][$i]['last_modified'].'<br>';
            echo $array['Files'][$i]['group_id'].'<br>';
            echo $array['Files'][$i]['user_id'].'<br>';
            echo $array['Files'][$i]['permision'].'<br>';
            echo "<hr>";
        }
    	/*foreach ($array['Files'] as $files)// With foreach loop
    	{
    		foreach ($files as $key => $value)
    		{
                echo $key . ' => ' . $value . '<br>';
    			if($key == 'permision') echo '<hr>';
    		}
    	}*/
    }
    else
    {
        echo 'NO FILES<br>';
    }

    if(!empty($array['Folders']))
    {
        /*for ($i = 0;$i < sizeof($array['Folders']); $i++) //With for loop
        {
            echo $array['Folders'][$i]['name'].'<br>';
            echo $array['Folders'][$i]['directory'].'<br>';
            echo $array['Folders'][$i]['link'].'<br>';
            echo $array['Folders'][$i]['size'].'<br>';
            echo $array['Folders'][$i]['extension'].'<br>';
            echo $array['Folders'][$i]['writeable'].'<br>';
            echo $array['Folders'][$i]['readable'].'<br>';
            echo $array['Folders'][$i]['time_created'].'<br>';
            echo $array['Folders'][$i]['last_accesed'].'<br>';
            echo $array['Folders'][$i]['last_modified'].'<br>';
            echo $array['Folders'][$i]['group_id'].'<br>';
            echo $array['Folders'][$i]['user_id'].'<br>';
            echo $array['Folders'][$i]['permision'].'<br>';
            echo "<hr>";
        }*/

    	foreach ($array['Folders'] as $files)
    	{
    		foreach ($files as $key => $value)
    		{
    			echo $key . ' => ' . $value . '<br>';
    			if($key == 'permision') echo '<hr>';
    		}
    	}
    }
    else
    {
        echo 'NO FOLDERS<br>';
    }
}
else
{
    echo $array['Status']['Message'];
}
?>