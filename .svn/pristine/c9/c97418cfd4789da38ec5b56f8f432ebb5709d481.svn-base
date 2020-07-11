<?php
ob_start();
// use google\appengine\api\cloud_storage\CloudStorageTools;
session_cache_expire(999999999);
if (! isset($_SESSION)) {
    session_start();
}

$my_bucket = "klkim-project.appspot.com";
// C:/xampp/htdocs/tbridge/attach/
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

function myUploadFile($myattachfolder, $filecontent, $savePath, $filename, $filetype, $filesize, $idx)
{
    $savePath = replaceFileNameIfExist($savePath);
    $url = "gs//";
    $url = "";
    if ($filesize == 0) {
        $filesize = 1;
    }
    if (file_exists($url . $myattachfolder . $savePath)) {
        myUploadFile($myattachfolder, $filecontent, replaceFileNameIfExist($savePath), $filename, $filetype, $filesize, $idx);
    } else {
		$_SESSION['images']=$list_images;
		
		echo '<img src="'.$_SESSION['domain'].'/attach/'.$myattachfolder.$savePath.'" style="margin:5px 0px;width: 150px;height:150px;border: 1px solid;">
                <input type="hidden" name="imagefile" value="attach/'.$myattachfolder.$savePath.'"/>
                <input type="hidden" name="imagepath" value="attach/'.$myattachfolder.$savePath.'"/>';

        // move_uploaded_file($filecontent,"gs://$myattachfolder$savePath" );

        move_uploaded_file($filecontent, $myattachfolder . $savePath);

        // $options = array('size' => 400,'crop' => true);
        // $image_file = "gs://$myattachfolder$savePath";
        // $image_url = CloudStorageTools::getImageServingUrl($image_file, $options);

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

        echo '<img src="' . $_SESSION['domain'] . '/attach/' . $myattachfolder . $savePath . '" style="margin:5px 0px;width: 150px;height:150px;border: 1px solid;">
                <input type="hidden" name="imagefile" value="attach/' . $myattachfolder . $savePath . '"/>
                <input type="hidden" name="imagepath" value="attach/' . $myattachfolder . $savePath . '"/>
>>>>>>> .r233
            ';

        // move_uploaded_file($filecontent,$myattachfolder.$savePath);
        // move_uploaded_file($filecontent, "gs://$myattachfolder$savePath");
    }
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
        $extensions = explode(".", $_FILES["file"]["name"][$idx]);
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
    
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
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
            continue;
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
ob_flush();
?>