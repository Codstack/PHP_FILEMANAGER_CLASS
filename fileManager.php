<?php
/**
 * Displaying selected file / directory information in form of JSON and Array
 *
 * You can get all of the information within your file / directory using this Class and display or use them in different ways
 * This Class consists of functions by which you can copy, move, delete, zip and etc... your files and folders.
 * In this Class there are two variables for a more accurate dispaying of information:
 * $extension : extension of files you want to be displayed
 * $fileDeny  : name of files / directories that you don't want to display them
 * NOTE: When giving $path in the function initFileManager() if you are entering directory address you need to put "/" at the end of it. But in case of files there is no need to add "/".
 *
 * @category   
 * @package    fileManager
 * @author     Codstack Team <codstack@gmail.com>
 * @copyright  2013 @ Codstack Team
 * @license    http://codstack.com/demos/PHP_FILEMANAGER_CLASS/
 * @version    Release: @package_1.0.0@
 * @link       http://codstack.com/demos/PHP_FILEMANAGER_CLASS/
 */
class fileManager
{
	/**
	 * extensions that user needs them to be displayed. These must be lowercase.
	 * Potential values are files extentions.
	 * @var array
	 * @access public
	 */
    public $extension = array();
    
    /**
	 * The name of files / directories that user don't want them to be displayed. It must be in form of a string.
	 * Potential values are deny files/directory name.
	 * @var array
	 * @access public
	 */
    public $fileDeny = array();
    
    /**
	 * Type of output that user wants to get
	 * Potential values are "json", "array".
	 * @var string
	 * @access public
	 */
    public $returnType;
    
    /**
	 * Type of json that user wants to get.
	 * json_file is a json file that is used by programmers of other languages like JAVA, AS3 and ...
	 * json_var is in form of a string and should be decoded. It is used more by PHP programmers.
	 * Potential values are "json_file", "json_var".
	 * @var string
	 * @access public
	 */
    public $typeJson;

    /**
	 * The address of file / directory.
     * You need to put "/" at the end of a directory. But in case of files there is no need to add "/".
	 * @var string
	 * @access private
	 */
    private $path;
    
    /**
	 * The Array in which file / directory data is saved.
	 * @var array
	 * @access private
	 */
    private $infoArr;

    /**
    * The start function. NOTE: You need to put "/" at the end of a directory. But in case of files there is no need to add "/".
    * @param  address of file or directory that you want to get information of it. $path
    * @return json or array of files or directories' information
    * @access public
    */
    public function initFileManager($path)
    {
        $this->path = $path;
        require_once 'JSON.php';
        require_once 'DEV.php';

        $result = $this->openDirectory();
        return $result;
    }

    /**
    * This function checks that the path is path of a file or directory.
    * If it was a file its information will be returned.
    * If it was a directory all of its files, directories and information will be returned.
    * @param
    * @return json or array of files or directories' information
    * @access private
    */
    private function openDirectory()
    {

        if(file_exists($this->path))
        {
            if(is_dir($this->path) and !in_array($this->path,$this->fileDeny))//Folder
            {
            	$this->infoArr['Status'] = array(
                    'Error' => 'NO',
                    'Message' => ''
                );
                $this->infoArr['Folders'] = array();
                $this->infoArr['Files'] = array();
               
                $results = scandir($this->path);

                foreach($results as $result)
                {
                    if(is_dir($this->path.$result) and !in_array($result,$this->fileDeny))
                    {
                        $size = $this->dirSize($this->path.$result);

                        $this->infoArr['Folders'][] = array(
                            'name' => $result,
                            'directory' => dirname($this->path.$result),
                            'link' => $this->linkPath($this->path.$result),
                            'size' => $size,
                            'writeable' => is_writable($this->path.$result),
                            'readable' => is_readable($this->path.$result),
                            'time_created' => date("YmdHis",filectime($this->path.$result)),
                            'last_accesed' => date("YmdHis",fileatime($this->path.$result)),
                            'last_modified' => date("YmdHis",filemtime($this->path.$result)),
                            'group_id' => filegroup($this->path.$result),
                            'user_id' => fileowner($this->path.$result),
                            'permision' => substr(sprintf('%o', fileperms($this->path.$result)), -4)
                        );
                    }
                    elseif(is_file($this->path.$result) and !in_array($result,$this->fileDeny))
                    {
                        $pathInfo = pathinfo($this->path.$result);
                        $extension = $pathInfo['extension'];
						$extension = strtolower($extension);

                        if(in_array($extension,$this->extension))
                        {
                            $this->infoArr['Files'][] = array(
                                'name' => $result,
                                'directory' => dirname($this->path.$result),
                                'link' => $this->linkPath($this->path.$result),
                                'size' => filesize($this->path.$result),
                                'extension' => $extension,
                                'writeable' => is_writable($this->path.$result),
                                'readable' => is_readable($this->path.$result),
                                'time_created' => date("YmdHis",filectime($this->path.$result)),
                                'last_accesed' => date("YmdHis",fileatime($this->path.$result)),
                                'last_modified' => date("YmdHis",filemtime($this->path.$result)),
                                'group_id' => filegroup($this->path.$result),
                                'user_id' => fileowner($this->path.$result),
                                'permision' => substr(sprintf('%o', fileperms($this->path.$result)), -4)
                            );

                        }

                    }

                }

            }
            elseif(is_file($this->path) and !in_array($this->path,$this->fileDeny))//file
            {
                $this->infoArr['Status'] = array(
                    'Error' => 'NO',
                    'Message' => ''
                );
                $this->infoArr['Folders'] = array();
                $this->infoArr['Files'] = array();

                $pathInfo = pathinfo($this->path);
                $extension = $pathInfo['extension'];
				$extension = strtolower($extension);

                if(in_array($extension,$this->extension))
                {
                    $this->infoArr['Files'][] = array(
                        'name' => basename($this->path),
                        'directory' => dirname($this->path),
                        'link' => $this->linkPath($this->path),
                        'size' => filesize($this->path),
                        'extension' => $extension,
                        'writeable' => is_writable($this->path),
                        'readable' => is_readable($this->path),
                        'time_created' => date("YmdHis",filectime($this->path)),
                        'last_accesed' => date("YmdHis",fileatime($this->path)),
                        'last_modified' => date("YmdHis",filemtime($this->path)),
                        'group_id' => filegroup($this->path),
                        'user_id' => fileowner($this->path),
                        'permision' => substr(sprintf('%o', fileperms($this->path)), -4)
                    );

                }

            }
        }
        else//agar directory vojod nadashte bashad
        {
            $this->infoArr['Status'] = array(
                'Error' => "Yes",
                'Message' => "Directory or file not exist"
            );
            $this->infoArr['Folders'] = array();
            $this->infoArr['Files'] = array();

        }
        $show = $this->showType($this->returnType);
        return $show;

    }

    /**
    * It returns informations in form of json_file, json_var or array.
    * @param  Type of output that user wants it to be returned.
    * @return json or array of files or directories' information
    * @access private
    */
    private function showType($type)
    {

        if($type == "" or $type == "json")
        {
            $json = new Services_JSON();// This Class changes an array into json.

            if($this->typeJson == 'json_var')
            {
                if(is_array($this->infoArr))
                {
                    //return json be sorate string
                    $output = $json->_encode($this->infoArr);
                    return $output;
                }
                else
                {
                    $this->infoArr['Status'] = array(
                        'Error' => 'YES',
                        'Message' => 'No Array Set'
                    );
                    $output = $json->_encode($this->infoArr);
                    return $output;
                }
            }
            elseif($this->typeJson == 'json_file' or $this->typeJson == '')
            {
                $dev = new Dev();

                if(is_array($this->infoArr))
                {
                    //return json be sorate file
                    $encode = $json->encode($this->infoArr);
                    $output = $dev->json_format($encode);
                    return $output;
                }
                else 
                {
                	$this->infoArr['Status'] = array(
                    	'Error' => 'YES',
                    	'Message' => 'No Array Set'
                	);
                	$encode = $json->encode($this->infoArr);
                    $output = $dev->json_format($encode);
                    return $output;
                }
            }
        }

        if($type == "array")
        {
        	if(is_array($this->infoArr))
            {
            	return $this->infoArr;
            }
            else
            {
            	$this->infoArr['Status'] = array(
                	'Error' => 'YES',
                    'Message' => 'No Array Set'
               	);
               	return $this->infoArr;
            }
        }
    }

    /**
    * It finds size of directory.
    * @param $directory: Address of directory.
    * @return It is based on bytes.
    * @access private
    */
    private function dirSize($directory)
    {
        $size = 0;

        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file)
        {
            $size+=$file->getSize();
        }
        return $size;
    }

    /**
    * It changes the bytes to other units by the choice of the function itself.
    * @param $bytes: Getting byte for the change
    * @return The changed byte to KB, MB or GB
    * @access public
    */
    public function changeSize($bytes)
    {
        if ($bytes > 0)
        {
            $unit = intval(log($bytes, 1024));
            $units = array('B', 'KB', 'MB', 'GB');

            if (array_key_exists($unit, $units) === true)
            {
                return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }
        else
            return $bytes;
    }

    /**
    * It changes the byte to other units by the choice of the function itself.
    * @param $bytes: gets bytes *** $format: gets the format to which byte is going to change.
    * @return The changed byte to KB, MB or GB
    * @access public
    */
    public function change_size($byte, $format)
    {
        if($byte > 0)
        {
            $format = strtoupper($format);
            switch($format)
            {
                case 'KB':  $byte = round($byte / pow(1024,1),1);
                    break;
                case 'MB': $byte = round($byte / pow(1024,2),1);
                    break;
                case 'GB': $byte = round($byte / pow(1204,3),2);
            }

            return $byte.' '.$format;
        }
        else return 0;
    }

    /**
    * adresse It changes file / directory to a link.
    * @param  $path: Address of file / directory.
    * @return Link of file / directory
    * @access public
    */
    public function linkPath($path)
    {
        $filename = basename($_SERVER["PHP_SELF"]);
        $this_file_path = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $link = str_replace($filename, $path, $this_file_path);
        return $link;
    }

    /**
    * This function is used to delete a directory.
    * NOTE: If there are read only files in the directory, this directory can not be deleted.
    * @param $directory: Address of file / directory
    * @return true or false
    * @access public
    */
    public function recursiveDelete($directory)
    {
        // if the path is not valid or is not a directory ...
        if(!file_exists($directory) || !is_dir($directory))
        {
            return false;
        }
        elseif(!is_readable($directory))// ... if the path is not readable
        {
            return false;
        }
        else // ... else if the path is readable
        {
            // open the directory
            $handle = opendir($directory);

            // and scan through the items inside
            while (false !== ($item = readdir($handle)))
            {
                // if the filepointer is not the current directory
                // or the parent directory
                if($item != '.' && $item != '..')
                {
                    // we build the new path to delete
                    $path = $directory.'/'.$item;

                    // if the new path is a directory
                    if(is_dir($path))
                    {
                        // we call this function with the new path
                        self::recursiveDelete($path);
                    }
                    else // if the new path is a file
                    {
                        // remove the file
                        unlink($path);
                    }
                }
            }

            // close the directory
            closedir($handle);

            // try to delete the now empty directory
            if(@!rmdir($directory))
            {
                return false;
            }

            return true;
        }
    }

    /**
    * It is used for copying  files / directories within a directory into another directory.
    * @param $destination: The address of directory that we want to copy. The place that we want the directory to be copied there.
    * @access public
    */
    public function copy_directory( $source, $destination )
    {
        if ( is_dir( $source ) )
        {
            @mkdir( $destination );
            $directory = dir( $source );
            while ( FALSE !== ( $readdirectory = $directory->read() ) )
            {
                if ( $readdirectory == '.' || $readdirectory == '..' )
                {
                    continue;
                }
                $PathDir = $source . '/' . $readdirectory;
                if ( is_dir( $PathDir ) )
                {
                    self::copy_directory( $PathDir, $destination . '/' . $readdirectory );
                    continue;
                }
                copy( $PathDir, $destination . '/' . $readdirectory );
            }

            $directory->close();
        }
        else
        {
            copy( $source, $destination );
        }
    }

    /**
    * This is used to rename a directory.
    * NOTE: You should enter names with their addresses.
    * NOTE: If there is a read only file in your directory, another directory will be created but the previous directory remains the same.
    * So it is better to check whether files within a directory are writable or not.
    * @param  dir.$oldName: New name of directory.
    * @return true or false
    * @access public
    */
    public function rename_directory($oldName, $newName)
    {
        if(is_dir($newName))
        {
            return false;
        }

        if(mkdir($newName))
        {
            $this->copy_directory($oldName, $newName);
            if(is_dir($newName))
            {
                $delete_old_dir = $this->recursiveDelete($oldName);
                if(is_dir($oldName))
                {
                    @chmod($oldName, 777);
                    rmdir($oldName);
                }

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
    *
    * @param $folderName: The address of directory that you want to zip.  $zipFileName: The place you want to make zip file in there. It is also the name of zip file.
    * @return true or false
    * @access public
    */
    public function create_zip($folderName,$zipFileName)
    {
        $zip = new ZipArchive();
        if(is_dir($folderName))
        {
            $zip_archive = $zip->open($zipFileName.".zip",ZIPARCHIVE::CREATE);
            if($zip_archive === true)
            {
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderName));
                foreach ($iterator as $key => $value)
                {
                    $check1 = strpos($key, '/.');
                    $check2 = strpos($key, '/..');
                    if($check1 === false and $check2 === false)
                    {
                        $zip->addFile(realpath($key), $key);
                    }
                }
                $zip->close();

                if(file_exists($zipFileName.".zip"))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
    }

    /**
    * This function is used to extract zip files.
    * NOTE: When entering the name of zip file you must use zip extension.
    * @param $pasteLocation: The name of the zip file with zip.$zipFileName extension and the place that you want to extract zip file to.
    * @return true or false
    * @access public
    */
    public function extract_zip($zipFileName,$pasteLocation)
    {
        if(!is_dir($pasteLocation))
        {
            mkdir($pasteLocation);
        }
        $zip = new ZipArchive();
        if ($zip->open($zipFileName) === TRUE)
        {
            for($i = 0; $i < $zip->numFiles; $i++)
            {
                $zip->extractTo($pasteLocation, array($zip->getNameIndex($i)));
            }
            $zip->close();
            if(is_dir($pasteLocation) or is_file($pasteLocation))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
    * For moving a directory to other directories
    * If there is a read only file in the target location, the directory will be created in newLocation but the directory remains in its source location.
    * @param Address of dir.$pathDir and where we want to move the directory to.
    * @return true or false
    * @access public
    */
    public function move_dir($pathDir,$destination)
    {
        $baseName = basename($pathDir);
        if(is_dir($pathDir))
        {
            $this->copy_directory($pathDir,$destination.'/'.$baseName);
            $this->recursiveDelete($pathDir);
            return true;
        }
        else
        	return false;
    }

    /**
     * it is used to make the date more userfriendly.
     * NOTE: The Date format should be as YmdHis (20130714092326). This is the format returned in fileManager class in form of json or array.
     * @param $date
     * @return string
     * @access public
     */
    public function change_date_format($date)
    {
        $_date = $date;
        $new_date = date("Y-m-d H:i:s");
        $date = date_parse($date);
        $new_date = date_parse($new_date);
        $years_ago = $new_date["year"] - $date["year"];
        if($years_ago != 0)
        {
            if($years_ago == 1)
            {
                return $years_ago." year ago";
                exit();
            }
            else
            {
                return $years_ago." years ago";
                exit();
            }
        }
        if($new_date["month"] == $date["month"] and $new_date["day"] == $date["day"] and $new_date["hour"] == $date["hour"] and $new_date["minute"] <= ($date["minute"] + 1))
        {
            return "Just now";
            exit();
        }
        $min_ago = $new_date["minute"] - $date["minute"];
        if($new_date["month"] == $date["month"] and $new_date["day"] == $date["day"] and $new_date["hour"] == $date["hour"])
        {
            return $min_ago." min ago";
            exit();
        }
        $hour_ago = $new_date["hour"] - $date["hour"];
        if($new_date["month"] == $date["month"] and $new_date["day"] == $date["day"])
        {
            if($hour_ago == 1)
            {
                return $hour_ago." hr ago";
                exit();
            }
            else
            {
                return $hour_ago." hrs ago";
                exit();
            }
        }
        $day_ago = $new_date["day"] - $date["day"];
        if($new_date["month"] == $date["month"] and $day_ago <= 10)
        {
            if($day_ago == 1)
            {
                return $day_ago." day ago";
                exit();
            }
            else
            {
                return $day_ago." days ago";
                exit();
            }
        }
        $dateModified = strtotime($_date);
        $dateModified = date("M j, Y", $dateModified);
        return $dateModified;
        exit();
    }

}

?>
