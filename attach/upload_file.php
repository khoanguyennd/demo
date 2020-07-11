<?php
/*namespace Google\Cloud\Samples\AppEngine\Storage;
 require PATH_ROOT.'/vendor/autoload.php';
 use Google\Cloud\Storage\StorageClient;
 function register_stream_wrapper($projectId) {
 $client = new StorageClient(['projectId' => $projectId]);
 $client->registerStreamWrapper();
 }
 register_stream_wrapper("klkim-project");
 */

$my_bucket = "klkim-project.appspot.com";
$myattachfolder = "$my_bucket/upload/";

$prefix = '';
if (isset($_REQUEST['prefix'])) {
    $prefix = $_REQUEST['prefix'];
}
$myattachfolder = $myattachfolder . $prefix;
$size = 0;
if (isset($_REQUEST['sizes'])) {
    $size = $_REQUEST['sizes'];
}


function replaceFileNameIfExist($savePath)
{
    $a = (string) (microtime(true) * 10000);
    $b = mb_split('\.', $a);
    $append = $b[0];
    
    $docPos = stripos($savePath, '.');
    $newPath = substr($savePath, 0, $docPos);
    return $newPath . $append . substr($savePath, $docPos);
}

function getPathImage($image_uri,$size){
    
    $my_bucket = "klkim-project.appspot.com";
    
    //$image_url = "https://".$my_bucket.".storage.googleapis.com/upload/".$image_uri;
    
    $image_url = "../attach/".$my_bucket."/upload/".$image_uri;//localhost
    
    return $image_url;
}

function saveImage($filecontent,$savePath){
    //move_uploaded_file($filecontent, "gs://$savePath");
    move_uploaded_file($filecontent, PATH_ROOT."/attach/".$savePath);//localhost
}

function myUploadFile($myattachfolder, $filecontent, $savePath, $filename, $filetype, $filesize, $idx)
{
    $savePath = replaceFileNameIfExist($savePath);
    $url = "gs://";
    $url = "../attach/"; // localhost
    if ($filesize == 0) {
        $filesize = 1;
    }
    
    
    //if (file_exists("$url$myattachfolder$savePath")) {
    //    myUploadFile($myattachfolder, $filecontent, replaceFileNameIfExist($savePath), $filename, $filetype, $filesize, $idx);
    //} else {
        
        saveImage($filecontent,$myattachfolder.$savePath);
        
        $image_uri=$savePath;
        $image_url = getPathImage($image_uri,460);
        
        $ImageId = microtime(true) * 10000;
        $list_images = array();
        if (isset($_SESSION['images']))
            $list_images = $_SESSION['images'];
            $list_images[] = array(
                $ImageId,
                $myattachfolder,
                $savePath,
                $filename,
                $filetype,
                $filesize
            );
            
            $_SESSION['images'] = $list_images;
            
            echo '<div style="display: inline-block;padding:5px" id="tbImages' . $ImageId . '" >
				<div >
				<a href="' . $image_url . '" class="highslide" onclick="return hs.expand(this)">
				<img src="' .URL_PUBLIC. 'images/imagetemp.png" style="margin:5px 0px;width: 120px;height: 120px;border: 1px solid;">
				</a>
				</div>
				    
				<div style="text-align: center;">
				<label>
				<input type="radio" name="representativeimage" onchange="checkAttach(this)" style="margin:1px" checked="checked" />representative
				<input type="hidden" id="flagattach" name="representative[]" value="true"/>
				</label>
				    
				<a onclick="delImages(' . $ImageId . ');" style="border: 1px solid;cursor: pointer;"> X </a>
				    
				<input type="hidden" name="imageId[]" value="' . $ImageId . '"/>
                <input type="hidden" name="imageuri[]" value="' . $image_uri . '"/>
				<input type="hidden" name="imagepath[]" value="' . $image_uri . '"/>
				    
				</div>
				</div>';
            
            /*
             * <input type="hidden" name="imagereal[]" value="'.$savePath.'"/>
             * <input type="hidden" name="imagefile[]" value="'.$filename.'"/>
             * <input type="hidden" name="imagetype[]" value="'.$filetype.'"/>
             * <input type="hidden" name="imagesize[]" value="'.$filesize.'"/>
             *
             * <a href="attach/downloadattach.php?
             * filepath='.urlencode($savePath).'&filename='.urlencode($filename).'&
             * filetype='.urlencode($filetype).'" >'.$filename.' ('.$filetype.') '.$filesize.'k </a>
             */
            
            //
    //}
}

function uploadSimpleFile($myattachfolder, $size)
{
    $prefix = '';
    if (isset($_REQUEST['prefix'])) {
        $prefix = $_REQUEST['prefix'];
    }
    
    if ($_FILES["file"]["error"][$idx] > 0) {
        return false;
    } else {
        $preventfiles = [
            'png',
            'jpg',
            'JPG',
            'jpeg',
            'JPEG',
            'PNG'
        ];
        
        $extensions = explode(".", $_FILES["file"]["name"]);
        $extension = end($extensions);
        if (in_array($extension, $preventfiles)) {
            myUploadFile($myattachfolder, $_FILES["file"]["tmp_name"], $_FILES["file"]["name"], $prefix . $_FILES["file"]["name"], $_FILES["file"]["type"], intval($_FILES["file"]["size"] / 1024), $size + 0);
        }else{
            return false;
        }
    }
}

function uploadMultipleFiles($myattachfolder, $size)
{
    $prefix = '';
    if (isset($_REQUEST['prefix'])) {
        $prefix = $_REQUEST['prefix'];
    }
    $preventfiles = [
        'png',
        'jpg',
        'JPG',
        'jpeg',
        'JPEG',
        'PNG'
    ];
    
    foreach ($_FILES["file"]["name"] as $idx => $name) {
        
        if ($_FILES["file"]["error"][$idx] > 0) {
            return false;
        } else {
            $extensions = explode(".", $_FILES["file"]["name"][$idx]);
            $extension = end($extensions);
            if (in_array($extension, $preventfiles)) {
                myUploadFile($myattachfolder, $_FILES["file"]["tmp_name"][$idx], $_FILES["file"]["name"][$idx], $prefix . $_FILES["file"]["name"][$idx], $_FILES["file"]["type"][$idx], intval($_FILES["file"]["size"][$idx] / 1024), $size + $idx);
            }else{
                return false;
            }
        }
    }
}

if (! isset($_FILES["file"])) {
    echo "Error: file empty <br />";
} else {
    if (is_array($_FILES["file"]["tmp_name"])) {
        uploadMultipleFiles($myattachfolder, $size);
    } else {
        uploadSimpleFile($myattachfolder, $size);
    }
    
    /*
     * echo "Upload: " . $_FILES["file"]["name"] . "<br />";
     * echo "Type: " . $_FILES["file"]["type"] . "<br />";
     * echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
     * echo "Stored in: " . $_FILES["file"]["tmp_name"];
     * if (file_exists("upload/" . $_FILES["file"]["name"]))
     * {
     * echo $_FILES["file"]["name"] . " already exists. ";
     * }
     * else
     * {
     * move_uploaded_file($_FILES["file"]["tmp_name"],
     * "upload/" . $_FILES["file"]["name"]);
     * echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
     * }
     */
}
?>