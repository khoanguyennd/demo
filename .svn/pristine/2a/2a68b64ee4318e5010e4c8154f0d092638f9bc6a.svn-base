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
$myattachfolder = "$my_bucket/upload/content/";
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

//     $url = "gs://";
//     $url = "../attach/"; // localhost

//     if ($filesize == 0) {
//         $filesize = 1;
//     }
//     if (file_exists("$url$myattachfolder$savePath")) {
//         myUploadFile($myattachfolder, $filecontent, replaceFileNameIfExist($savePath), $filename, $filetype, $filesize, $idx);
//     } else {

        saveImage($filecontent,$myattachfolder.$savePath);
        
        $image_uri="content/".$savePath;
        $image_url = getPathImage($image_uri,460);

        echo '
		<a href="' . $image_url . '" class="highslide" onclick="return hs.expand(this)">
		<img src="' .URL_PUBLIC. 'images/imagetemp.png" style="margin:5px 0px;width: 120px;height:50px;border: 1px solid;">
		</a>
			<input type="hidden" name="imagecontentpath[]" value="' . $image_uri . '"/>	
            <input type="hidden" name="imagecontenturi[]" value="' . $image_uri . '"/>	
		';

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

        // move_uploaded_file($filecontent,$myattachfolder.$savePath);
        // move_uploaded_file($filecontent, "gs://$myattachfolder$savePath");
    //}
}

function uploadSimpleFile($myattachfolder, $size)
{
    $prefix = '';
    if (isset($_REQUEST['prefix'])) {
        $prefix = $_REQUEST['prefix'];
    }
    
    if ($_FILES["ppic_detail"]["error"][$idx] > 0) {
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
        
        $extensions = explode(".", $_FILES["ppic_detail"]["name"]);
        $extension = end($extensions);
        if (in_array($extension, $preventfiles)) {
            myUploadFile($myattachfolder, $_FILES["ppic_detail"]["tmp_name"], $_FILES["ppic_detail"]["name"], $prefix . $_FILES["ppic_detail"]["name"], $_FILES["ppic_detail"]["type"], intval($_FILES["ppic_detail"]["size"] / 1024), $size + 0);
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
    
    foreach ($_FILES["ppic_detail"]["name"] as $idx => $name) {
        
        if ($_FILES["ppic_detail"]["error"][$idx] > 0) {
            return false;
        } else {
            $extensions = explode(".", $_FILES["ppic_detail"]["name"][$idx]);
            $extension = end($extensions);
            if (in_array($extension, $preventfiles)) {
                myUploadFile($myattachfolder, $_FILES["ppic_detail"]["tmp_name"][$idx], $_FILES["ppic_detail"]["name"][$idx], $prefix . $_FILES["ppic_detail"]["name"][$idx], $_FILES["ppic_detail"]["type"][$idx], intval($_FILES["ppic_detail"]["size"][$idx] / 1024), $size + $idx);
            }else{
                return false;
            }
        }
    }
}

if (! isset($_FILES["ppic_detail"])) {
    echo "Error: file empty <br />";
} else {
    if (is_array($_FILES["ppic_detail"]["tmp_name"])) {
        uploadMultipleFiles($myattachfolder, $size);
    } else {
        uploadSimpleFile($myattachfolder, $size);
    }

    /*
     * echo "Upload: " . $_FILES["ppic_detail"]["name"] . "<br />";
     * echo "Type: " . $_FILES["ppic_detail"]["type"] . "<br />";
     * echo "Size: " . ($_FILES["ppic_detail"]["size"] / 1024) . " Kb<br />";
     * echo "Stored in: " . $_FILES["ppic_detail"]["tmp_name"];
     * if (file_exists("upload/" . $_FILES["ppic_detail"]["name"]))
     * {
     * echo $_FILES["ppic_detail"]["name"] . " already exists. ";
     * }
     * else
     * {
     * move_uploaded_file($_FILES["ppic_detail"]["tmp_name"],
     * "upload/" . $_FILES["ppic_detail"]["name"]);
     * echo "Stored in: " . "upload/" . $_FILES["ppic_detail"]["name"];
     * }
     */
}
?>