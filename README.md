PHP_FILEMANAGER_CLASS
=====================
<p>
   If you see the <a href="http://codstack.com/demos/PHP_FILEMANAGER_CLASS/" target="_blank">preview</a> of this item you can find out how it works but let's cover it in detail:
</p>

<p style="padding-bottom: 12px;">Firstly you need to include File Manager Class in your project:<br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        include 'fileManager.php';
    </code>
</p>

<p style="padding-bottom: 12px;">Secondly you need to initialize File Manager Class:<br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        $manager = new fileManager();
    </code>
</p>

<p style="padding-bottom: 12px;">Now you can determine which file extension will be shown for you ( you can set any extensions you wish ):<br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        $manager->extension = array('txt','jpg','png', 'mp3', 'zip');
    </code>
</p>

<p style="padding-bottom: 12px;">Now you can determine which file / folder will not be shown by their names:<br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        $manager->fileDeny = array('.', '..');
    </code>
</p>

<p>Then you need to choose the returned type ( Array or JSON ):<br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        $manager->returnType = 'array';
    </code><br>
</p>
<p style="padding-bottom: 12px;">
    If you want to choose a JSON you need to define its type ( json_file <b>or</b> json_var ):<br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        $manager->typeJson = "json_file";
    </code> <br><br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        $manager->typeJson = "json_var";
    </code>
</p>

<p style="padding-bottom: 12px;">Finally you should give the file / folder path ( if it is a folder path you need to add "/" at the end of the path ) to initFileManager():<br>
    <code style="background-color: #f7f7f9; padding: 10px; border-radius: 3px; top: 10px; position: relative;">
        $array = $manager->initFileManager('demo/');
    </code>
</p>

<center><hr style="width: 400px;"></center>
<p>In order to edit your server folders there are four useful functions:<br>
    <ul>
        <li>recursiveDelete()</li>
        <li>copy_directory()</li>
        <li>rename_directory()</li>
        <li>move_dir()</li>
        <li>create_zip()</li>
        <li>extract_zip()</li>
        <li>linkPath()</li>
    </ul>
    </p>

    <p>In order to edit your server files / folders data there are three useful functions:<br>
    <ul>
        <li>change_date_format()</li>
        <li>change_size()</li>
        <li>changeSize()</li>
    </ul>
    </p>

<hr>
    <p>
        <b>NOTE</b>: All of the functions or variables are commented in a standard way in detail.
    </p>
    <p>
        Please refer to the example folder within the FILEMANAGER_PHP_CLASS.zip file you have just downloaded.
    </p>
    <hr>

<h3 id="credits"><strong>E) Sources and Credits</strong></h3>

<p>We've used the following.

<ul>
	<li>DEV.php</li>
        <li>JSON.php</li>
</ul>

<hr>
