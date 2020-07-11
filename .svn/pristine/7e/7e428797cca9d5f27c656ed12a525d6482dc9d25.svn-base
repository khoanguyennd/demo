<?php class Ticket4Controller extends Controller
{
    // Phương thức khởi tạo
    public function __construct($params)
    {
        parent::__construct($params);
        $this->isLogin();
        $account = $_SESSION['accountshopping'];
        if($account['temp']==1)
            Url::header($this->route('account')."#tab1");
    }
    // Phương thức mã hóa password
    public function md5Password($password)
    {
        return md5($password);
        // return md5(md5('*)2^).-+(479&##' . $password . '#8$#@%^457'));
    }    
   
    public function editticket4Action()
    {
    	$sellerProductId=$this->_params['sellerProductId'];
        if(isset($this->_params['btnSumit']) && $this->_params['btnSumit']=="editticket4"){      
            
            // update statusedit
            //$data = [ 'statusedit' => 1, 'status' => 0 ];
            $this->_model->updateRecord('salechannel', ["statusedit" => 1], ['sellerProductId' => $sellerProductId]);
            
            $step=$this->_params['step'];
            $this->_model->deleteRecord('images',["sellerProductId"=>$sellerProductId]);
            
            if(isset($this->_params['imageId'])){
                $imageId=$this->_params['imageId'];
                $imagepath=$this->_params['imagepath'];
                $imagepath=$this->_params['imageuri'];
                $representative=$this->_params['representative'];
                for($i=0;$i<count($imageId);$i++){
                    $check =0;
                    if($representative[$i]=="true")
                        $check =1;
                    $this->_model->insertRecord('images',
                        [   'sellerProductId'=>$sellerProductId,
                            'imageId'=>$imageId[$i],
                            'sellerUrl'=>$imagepath[$i],
                            'sellerUrlMethod'=>'GET',
                            'representative'=>$check,
                            'sellerImageCategory'=>"1234",
                            'imageGroup'=>"BASIC",
                            'description'=>"",
                            'seq'=>$i, 
                            'type'=>1
                        ]);
                }
                ///unset($_SESSION['images']);
            }
            
            if(isset($this->_params['imageId1'])){
                $imageId=$this->_params['imageId1'];
                $imagepath=$this->_params['imagepath1'];
                $imagepath=$this->_params['imageuri1'];
                $representative=$this->_params['representative1'];
                for($i=0;$i<count($imageId);$i++){
                    $check =0;
                    if($representative[$i]=="true")
                        $check =1;
                    $this->_model->insertRecord('images',
                         [  'sellerProductId'=>$sellerProductId,
                            'imageId'=>$imageId[$i],
                            'sellerUrl'=>$imagepath[$i],
                            'sellerUrlMethod'=>'GET',
                            'representative'=>$check,
                            'sellerImageCategory'=>"1234",
                            'imageGroup'=>"BASIC",
                            'description'=>"",
                            'seq'=>$i, 
                            'type'=>2
                         ]);
                }
                //unset($_SESSION['images1']);
            }
            
            $this->_model->deleteRecord('contents',["sellerProductId"=>$sellerProductId]);
            
            if(isset($this->_params['contentId']) && $this->_params['pformat']=="IMAGE"){
                $contentId=$this->_params['contentId'];
                $title=$this->_params['ptitle'];
                $format=$this->_params['pformat'];
                $imagecontentpath=$this->_params['imagecontentpath'];
                $content=$this->_params['htmlContent'];
                
                for($i=0;$i<count($contentId);$i++){
                    $this->_model->insertRecord('contents',
                        [   'sellerProductId'=>$sellerProductId,
                            'contentId'=>$contentId[$i],
                            'title'=>$title[$i],
                            'type'=>'Product-Content',
                            'content'=>$content,
                            'format'=>$format,
                            'sellerUrl'=>$imagecontentpath[$i],
                            'sellerUrlMethod'=>"GET",
                            'seq'=>$i
                        ]);
                }
            }
            if( $this->_params['pformat']=="TEXT"){
                $contentId=microtime(true)*10000;
                $format=$this->_params['pformat'];
                $content=$this->_params['htmlContent'];
                $this->_model->insertRecord('contents',
                    [   'sellerProductId'=>$sellerProductId,
                        'contentId'=>$contentId,
                        'title'=>"",
                        'type'=>'Product-Content',
                        'content'=>$content,
                        'format'=>$format,
                        'sellerUrl'=>"",
                        'sellerUrlMethod'=>"GET",
                        'seq'=>1
                    ]);
            }
            
            
            $url = $this->route('editticket'.$step) . "/" . $sellerProductId;
            if($step==4){
            	$this->_view->setData('urlstep', $url);
            }else{
            	Url::header($url);
            }                      
        }
            

    	$list_sellerProduct = $this->_model->loadRecords('sellerproduct', [
    			'sellerProductId' => $sellerProductId
    	]);
    	// Kiểm tra $sellerProductId tồn tại
    	if(!$list_sellerProduct){
    		$this->pageError();
    		return  false;
    	}           
        $this->_view->setData('sellerProductId', $sellerProductId);            
        
        $result=$this->_model->loadRecords('images',['sellerProductId'=>$sellerProductId]);
        $list_images=array();
        
        foreach ($result as $value =>$giatri){
            $list_images[]=array($giatri['imageId'],$giatri['sellerUrl'],$giatri['sellerUrlMethod'],$giatri['representative'],
                                 $giatri['sellerImageCategory'],$giatri['imageGroup'],$giatri['description'],$giatri['seq'],$giatri['type']); 
        }
        $this->_view->setData('list_images', $list_images);
        
        $result=$this->_model->loadRecords('contents',['sellerProductId'=>$sellerProductId]);
        $list_contents=array();
        $format="IMAGE";
        foreach ($result as $value =>$giatri){
            $format=$giatri['format'];
            $list_contents[]=array($giatri['contentId'],$giatri['title'],$giatri['type'],$giatri['content'],$giatri['format'],
                                   $giatri['sellerUrl'],$giatri['sellerUrlMethod'],$giatri['seq']);
        }
        $this->_view->setData('format', $format);
        $this->_view->setData('list_contents', $list_contents);
        $this->_view->render('editticket4');
    }
    // Phương thức ajax
    public function addContentAjax()
    {
        $contentId=microtime(true)*10000;
        $str='<tr id="tbContent'.$contentId.'" class="contBox" style="padding: 10px">
    			<td>
            	<input name="contentId[]" id="contentId" type="hidden" value="'.$contentId.'" />
                <input name="ptitle[]" id="ptitle'.$contentId.'" type="text" value="a" style="display: none;">
                <select name="" style="width: 150px; height: 24px;display: none;" class="TextBoxField">
            				<option value="TEXT" >IMAGE</option>
            				<option value="IMAGE">IMAGE</option>
            	</select>
            	</td>
            	<td>
                    <div style="display: inline-block;width: 165px;text-align: center;">
                	    <div id="uploadresult'.$contentId.'" style="clear: both">
                	    	<input type="hidden" name="imagecontentpath[]" value=""/>
                	    </div>
                	    <div id="appendbrowser'.$contentId.'"  class="inputWrapper">
                        <div class="btnupload"><button type="button" class="btn hover small">등록하기</button></div>
                		<input  type="file" name="ppic_detail" title="browserfile'.$contentId.'" 
                                id="myfile'.$contentId.'" class="fileInput" accept="image/*" onchange="changeBrowsers2(this,\'browserfile'.$contentId.'\','.$contentId.')"/>
                	    </div>
                	    <div id="attachloading'.$contentId.'"></div>
                    </div>
                </td>
                <td>
                </td>
                <td>
                     <div style="display: inline-block;vertical-align: top;padding-top: 5px;display: none;">
                    <textarea name="pcontent[]" id="pcontent'.$contentId.'" style="width:680px; height:80px;line-height: 24px;resize:none;">a</textarea>
                    </div>
                    <div style="display: inline-block;vertical-align: top;padding-top: 5px;">
                        <div class="btnupload" style="float: right;margin: -5px 0px -5px 0px;">										
    							<button type="button" class="btn hover small " onclick="delContent('.$contentId.');">'.$this->_view->getItem('language', 'l_delete').'</button>
    					</div>
                	</div>
            	</td>
            	
            </tr>';
        echo $str;
        
    }

    public function uploadImageAjax(){
        $result = array();
        if( isset($_FILES['file'])){
            $file = new Upload();
            for($i=0; $i<count($_FILES['file']['name']);$i++){
                $file->_fileName = $_FILES['file']['name'][$i];
                $file->_fileSize = $_FILES['file']['size'][$i];
                $file->_fileTmp = $_FILES['file']['tmp_name'][$i];
                $file->_fileExtension = $file->getFileExtension ();
                $file->setFileSize(FILE_SIZE);
                $file->setFileExtension(IMAGE_EXTENSION);
                $file->setUploadDir('klkim-project.appspot.com/upload' . DS);
                if(!$file->showError()){
                    // upload
                    $image_uri= $file->uploadFile(true); 
                    $result['filename'][$i]= $image_uri;
                    $image_url = Func::getPathImage($image_uri,460);
                    $ImageId = microtime(true) * 10000;
                    
                    $checked="";
                    $bool="false";
                    if(isset($this->_params['seq']) && $this->_params['seq']==1){
                        $checked='checked="checked"';
                        $bool="true";
                    }
                    echo '<div style="display: inline-block;padding:5px" id="tbImages' . $ImageId . '" >
    				<div >
        				<a href="' . $image_url . '" class="highslide" onclick="return hs.expand(this)">
        				<img src="' . $image_url . '" style="margin:5px 0px;width: 120px;height: 120px;border: 1px solid;">
        				</a>
    				</div>
        				<div style="text-align: center;">
                            <input type="radio" name="representativeimage" id="checkrepresentativeimage'.$ImageId.'" 
                                    onchange="checkAttach(this)" style="margin: -2px 0px 0px 0px;vertical-align: middle;" '.$checked.'/>
            				<label for="checkrepresentativeimage'.$ImageId.'" style="vertical-align: middle;">'.$this->_view->getItem('language', 'l_imagerepresentative').'</label>
                            <input type="hidden" id="flagattach" name="representative[]" value="'.$bool.'"/>

            				<a onclick="delImages(1,'.$ImageId .');" class="btn hover small" style="padding: 5px;"> X </a>
            				<input type="hidden" name="imageId[]" value="' . $ImageId . '"/>
                            <input type="hidden" name="imageuri[]" value="' . $image_uri . '"/>
            				<input type="hidden" name="imagepath[]" value="' . $image_uri . '"/>
        				</div>
    				</div>';
                    
                    $result['flag'][$i] = true;
                }else{
                    $result['error'][$i] = $this->convertErrUpload($file->showError());
                }
            }
        }
    }
    
    public function uploadImage1Ajax(){
        $result = array();
        if( isset($_FILES['file1'])){
            $file = new Upload();
            for($i=0; $i<count($_FILES['file1']['name']);$i++){
                $file->_fileName = $_FILES['file1']['name'][$i];
                $file->_fileSize = $_FILES['file1']['size'][$i];
                $file->_fileTmp = $_FILES['file1']['tmp_name'][$i];
                $file->_fileExtension = $file->getFileExtension ();
                $file->setFileSize(FILE_SIZE);
                $file->setFileExtension(IMAGE_EXTENSION);
                $file->setUploadDir('klkim-project.appspot.com/upload' . DS);
                if(!$file->showError()){
                    // upload
                    $image_uri= $file->uploadFile(true);
                    $result['filename'][$i]= $image_uri;
                    $image_url = Func::getPathImage($image_uri,460);
                    $ImageId = microtime(true) * 10000;
                    echo '<div style="display: inline-block;padding:5px" id="tbImages' . $ImageId . '" >
    				<div >
        				<a href="' . $image_url . '" class="highslide" onclick="return hs.expand(this)">
        				<img src="' . $image_url . '" style="margin:5px 0px;width: 120px;height: 120px;border: 1px solid;">
        				</a>
    				</div>
        				<div style="text-align: center;">
                            <input type="radio" name="representativeimage1" id="checkrepresentativeimage'.$ImageId.'" onchange="checkAttach1(this)"style="margin: -2px 0px 0px 0px;vertical-align: middle;display: none;" />
        				    <label for="checkrepresentativeimage'.$ImageId.'" style="vertical-align: middle;display: none;">'.$this->_view->getItem('language', 'l_imagerepresentative').'</label>
                            <input type="hidden" id="flagattach1" name="representative1[]" value="false"/>
        				    <a onclick="delImages(2,'. $ImageId.');" class="btn hover small" style="padding: 5px;"> X </a>
            				<input type="hidden" name="imageId1[]" value="' . $ImageId . '"/>
                            <input type="hidden" name="imageuri1[]" value="' . $image_uri . '"/>
            				<input type="hidden" name="imagepath1[]" value="' . $image_uri . '"/>
        				</div>
    				</div>';
                    
                    $result['flag'][$i] = true;
                }else{
                    $result['error'][$i] = $this->convertErrUpload($file->showError());
                }
            }
        }
    }
    
    
    public function uploadImage10Ajax(){
        $result = array();
        $contentId=microtime(true)*10000;
        if( isset($_FILES['file10'])){
            $file = new Upload();
            for($i=0; $i<count($_FILES['file10']['name']);$i++){
                $file->_fileName = $_FILES['file10']['name'][$i];
                $file->_fileSize = $_FILES['file10']['size'][$i];
                $file->_fileTmp = $_FILES['file10']['tmp_name'][$i];
                $file->_fileExtension = $file->getFileExtension ();
                $file->setFileSize(FILE_SIZE);
                $file->setFileExtension(IMAGE_EXTENSION);
                $file->setUploadDir('klkim-project.appspot.com/upload/content' . DS);
                if(!$file->showError()){
                    // upload
                    $result['filename'][$i]= $file->uploadFile(true);
                    $image_uri="content/".$result['filename'][$i];
                    $image_url = Func::getPathImage($image_uri,460);
                    $contentId ++;
                    $str=htmlentities('<tr id="tbContent'.$contentId.'" class="contBox" style="padding: 10px">
                			<td>
                        	<input name="contentId[]" id="contentId" type="hidden" value="'.$contentId.'" />
                            <input name="ptitle[]" id="ptitle'.$contentId.'" type="text" value="a" style="display: none;">
                            <select name="" style="width: 150px; height: 24px;display: none;" class="TextBoxField">
                        				<option value="TEXT" >IMAGE</option>
                        				<option value="IMAGE">IMAGE</option>
                        	</select>
                        	</td>
                        	<td>
                                <div style="display: inline-block;width: 165px;text-align: center;">
                            	    <div id="uploadresult'.$contentId.'" style="clear: both">
                            	    	<a href="' . $image_url . '" class="highslide" onclick="return hs.expand(this)">
                                		  <img src="' .$image_url. '" style="margin:5px 0px;width: 120px;height:50px;border: 1px solid;">
                                		</a>
                            			<input type="hidden" name="imagecontentpath[]" value="' . $image_uri . '"/>
                                        <input type="hidden" name="imagecontenturi[]" value="' . $image_uri . '"/>
                            	    </div>
                            	    <div id="appendbrowser'.$contentId.'"  class="inputWrapper">
                                    <div class="btnupload"><button type="button" class="btn hover small">등록하기</button></div>
                            		<input  type="file" name="ppic_detail" title="browserfile'.$contentId.'"
                                            id="myfile'.$contentId.'" class="fileInput" accept="image/*" onchange="changeBrowsers2(this,\'browserfile'.$contentId.'\','.$contentId.')"/>
                            	    </div>
                            	    <div id="attachloading'.$contentId.'"></div>
                                </div>
                            </td>
                            <td>
                            </td>
                            <td>
                                 <div style="display: inline-block;vertical-align: top;padding-top: 5px;display: none;">
                                <textarea name="pcontent[]" id="pcontent'.$contentId.'" style="width:680px; height:80px;line-height: 24px;resize:none;">a</textarea>
                                </div>
                                <div style="display: inline-block;vertical-align: top;padding-top: 5px;">
                                    <div class="btnupload" style="float: right;margin: -5px 0px -5px 0px;">
                							<button type="button" class="btn hover small " onclick="delContent('.$contentId.');">'.$this->_view->getItem('language', 'l_delete').'</button>
                					</div>
                            	</div>
                        	</td>
                							    
                        </tr>');
                    echo $str;
                    
                    $result['flag'][$i] = true;
                }else{
                    $result['error'][$i] = $this->convertErrUpload($file->showError());
                }
            }
        }
    }
    public function uploadImage2Ajax(){
        $result = ['flag'=>false];
        if( isset($_FILES['ppic_detail'])){
            $file = new Upload('ppic_detail');
            $file->setFileExtension(IMAGE_EXTENSION);
            $file->setUploadDir('klkim-project.appspot.com/upload/content' . DS);
            
            //             echo $file->showError();
            if(!$file->showError()){
                // upload
                $result['filename'] = $file->uploadFile(true);
                $image_uri="content/".$result['filename'] ;
                $image_url = Func::getPathImage($image_uri,460);
                echo '
        		<a href="' . $image_url . '" class="highslide" onclick="return hs.expand(this)">
        		  <img src="' .$image_url. '" style="margin:5px 0px;width: 120px;height:50px;border: 1px solid;">
        		</a>
    			<input type="hidden" name="imagecontentpath[]" value="' . $image_uri . '"/>
                <input type="hidden" name="imagecontenturi[]" value="' . $image_uri . '"/>
        		';
                
                $result['flag'] = true;
            }else{
                $result['error'] = $this->convertErrUpload($file->showError());
            }
            
            
            
        }
    }
    
}
?>