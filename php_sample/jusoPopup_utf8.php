<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<?php
$inputYn= "N";
$roadFullAddr= 'a';
$roadAddrPart1= 'a';
$roadAddrPart2= 'a';
$engAddr= 'a';
$jibunAddr= 'a';
$zipNo= 'a';
$addrDetail= 'a';
$admCd= 'a';
$rnMgtSn= 'a';
$bdMgtSn= 'a';
$detBdNmList= 'a';
//** 2017년 2월 제공항목 추가 **/
$bdNm= 'a';
$bdKdcd= 'a';
$siNm= 'a';
$sggNm= 'a';
$emdNm= 'a';
$liNm= 'a';
$rn= 'a';
$udrtYn= 'a';
$buldMnnm= 'a';
$buldSlno= 'a';
$mtYn= 'a';
$lnbrMnnm= 'a';
$lnbrSlno= 'a';
//** 2017년 3월 제공항목 추가 **/
$emdNo= '';

if(isset($_POST['inputYn'])){
	$inputYn= $_POST['inputYn'];
	$roadFullAddr= $_POST['roadFullAddr'];
	$roadAddrPart1= $_POST['roadAddrPart1'];
	$roadAddrPart2= $_POST['roadAddrPart2'];
	$engAddr= $_POST['engAddr'];
	$jibunAddr= $_POST['jibunAddr'];
	$zipNo= $_POST['zipNo'];
	$addrDetail= $_POST['addrDetail'];
	$admCd= $_POST['admCd'];
	$rnMgtSn= $_POST['rnMgtSn'];
	$bdMgtSn= $_POST['bdMgtSn'];
	$detBdNmList= $_POST['detBdNmList'];
	//** 2017년 2월 제공항목 추가 **/
	$bdNm= $_POST['bdNm'];
	$bdKdcd= $_POST['bdKdcd'];
	$siNm= $_POST['siNm'];
	$sggNm= $_POST['sggNm'];
	$emdNm= $_POST['emdNm'];
	$liNm= $_POST['liNm'];
	$rn= $_POST['rn'];
	$udrtYn= $_POST['udrtYn'];
	$buldMnnm= $_POST['buldMnnm'];
	$buldSlno= $_POST['buldSlno'];
	$mtYn= $_POST['mtYn'];
	$lnbrMnnm= $_POST['lnbrMnnm'];	
	$lnbrSlno= $_POST['lnbrSlno'];
	//** 2017년 3월 제공항목 추가 **/
	$emdNo= $_POST['emdNo'];
	
}

?>
</head>
<script language="javascript">
// opener관련 오류가 발생하는 경우 아래 주석을 해지하고, 사용자의 도메인정보를 입력합니다. ("주소입력화면 소스"도 동일하게 적용시켜야 합니다.)
//document.domain = "abc.go.kr";

/*
		모의 해킹 테스트 시 팝업API를 호출하시면 IP가 차단 될 수 있습니다. 
		주소팝업API를 제외하시고 테스트 하시기 바랍니다.
*/

function init(){
	var url = location.href;
	var confmKey = "U01TX0FVVEgyMDIwMDMyNTE4MjIyMDEwOTU4NTA=";
	var resultType = "4"; // 도로명주소 검색결과 화면 출력내용, 1 : 도로명, 2 : 도로명+지번, 3 : 도로명+상세건물명, 4 : 도로명+지번+상세건물명
	// php.ini 에 short_open_tag 가 On 으로 설정되어 되어 있는 경우 아래 소스 코드 사용
	var inputYn= "<?=$inputYn?>";
	
	if(inputYn != "Y"){
		document.form.confmKey.value = confmKey;
		document.form.returnUrl.value = url;
		document.form.resultType.value = resultType;
		document.form.action="http://www.juso.go.kr/addrlink/addrLinkUrl.do"; //인터넷망
		//document.form.action="http://www.juso.go.kr/addrlink/addrMobileLinkUrl.do"; //모바일 웹인 경우, 인터넷망
		document.form.submit();
	}else{
		opener.jusoCallBack("<?=$roadFullAddr?>","<?=$jibunAddr?>","<?=$zipNo?>","<?=$siNm?>","<?=$sggNm?>","<?=$emdNm?>");
		window.close();
	}
}
</script>

<body onload="init();">
	<form id="form" name="form" method="post">
		<input type="hidden" id="confmKey" name="confmKey" value=''/>
		<input type="hidden" id="returnUrl" name="returnUrl" value=''/>
		<input type="hidden" id="resultType" name="resultType" value=''/>
		<!-- 해당시스템의 인코딩타입이 EUC-KR일경우에만 추가 START-->
		<!--input type="hidden" id="encodingType" name="encodingType" value="EUC-KR"/-->
		<!-- 해당시스템의 인코딩타입이 EUC-KR일경우에만 추가 END-->
	</form>
</body>
</html>