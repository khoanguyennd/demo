<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-KR">
<title>Insert title here</title>
</head>
<script language="javascript">
// opener���� ������ �߻��ϴ� ��� �Ʒ� �ּ��� �����ϰ�, ������� ������������ �Է��մϴ�. ("�˾�API ȣ�� �ҽ�"�� �����ϰ� ������Ѿ� �մϴ�.)
//document.domain = "abc.go.kr";

function jusoCallBack(roadFullAddr,roadAddrPart1,addrDetail,roadAddrPart2,engAddr,jibunAddr,zipNo,admCd,rnMgtSn,bdMgtSn,detBdNmList,bdNm,bdKdcd,siNm,sggNm,emdNm,liNm,rn,udrtYn,buldMnnm,buldSlno,mtYn,lnbrMnnm,lnbrSlno,emdNo){
	document.getElementById('roadFullAddr').value = roadFullAddr;
	document.getElementById('roadAddrPart1').value = roadAddrPart1;
	document.getElementById('addrDetail').value = addrDetail;
	document.getElementById('roadAddrPart2').value = roadAddrPart2;
	document.getElementById('engAddr').value = engAddr;
	document.getElementById('jibunAddr').value = jibunAddr;
	document.getElementById('zipNo').value = zipNo;
	document.getElementById('admCd').value = admCd;
	document.getElementById('rnMgtSn').value = rnMgtSn;
	document.getElementById('bdMgtSn').value = bdMgtSn;
	document.getElementById('detBdNmList').value = detBdNmList;
	//** 2017�� 2�� �����׸� �߰� **/
	document.getElementById('bdNm').value = bdNm;
	document.getElementById('bdKdcd').value = bdKdcd;
	document.getElementById('siNm').value = siNm;
	document.getElementById('sggNm').value = sggNm;
	document.getElementById('emdNm').value = emdNm;
	document.getElementById('liNm').value = liNm;
	document.getElementById('rn').value = rn;
	document.getElementById('udrtYn').value = udrtYn;
	document.getElementById('buldMnnm').value = buldMnnm;
	document.getElementById('buldSlno').value = buldSlno;
	document.getElementById('mtYn').value = mtYn;
	document.getElementById('lnbrMnnm').value = lnbrMnnm;
	document.getElementById('lnbrSlno').value = lnbrSlno;
	//** 2017�� 3�� �����׸� �߰� **/
	document.getElementById('emdNo').value = emdNo;	
}

function goPopup(){
	// �ּҰ˻��� ������ �˾� �������� ȣ���մϴ�.
	// ȣ��� ������(jusoPopup.php)���� ���� �ּҰ˻�URL(http://www.juso.go.kr/addrlink/addrLinkUrl.do)�� ȣ���ϰ� �˴ϴ�.
	var pop = window.open("http://localhost:8000/tbridge/php_sample/jusoPopup.php","pop","width=570,height=420, scrollbars=yes, resizable=yes"); 
	
	// ����� ���� ���, ȣ��� ������(jusoPopup.php)���� ���� �ּҰ˻�URL(http://www.juso.go.kr/addrlink/addrMobileLinkUrl.do)�� ȣ���ϰ� �˴ϴ�.
    //var pop = window.open("/jusoPopup.php","pop","scrollbars=yes, resizable=yes"); 
}
</script>
<body onload="jusoCallBack('roadFullAddr','roadAddrPart1','addrDetail','roadAddrPart2','engAddr','jibunAddr','zipNo','admCd','rnMgtSn','bdMgtSn','detBdNmList','bdNm','bdKdcd','siNm','sggNm','emdNm','liNm','rn','udrtYn','buldMnnm','buldSlno','mtYn','lnbrMnnm','lnbrSlno','emdNo');">
<input type="button" value="�ּҰ˻�" onclick="goPopup();"> 
	<form name="rdnAddr">
		<input id ="roadFullAddr">
		<input id ="roadAddrPart1">
		<input id ="addrDetail">
		<input id ="roadAddrPart2">
		<input id ="engAddr">
		<input id ="jibunAddr">
		<input id ="zipNo">
		<input id ="admCd">
		<input id ="rnMgtSn">
		<input id ="bdMgtSn">		
		<input id ="detBdNmList">
		
		<input id ="bdNm">
		<input id ="bdKdcd">
		<input id ="siNm">
		<input id ="sggNm">
		<input id ="emdNm">
		<input id ="liNm">
		<input id ="rn">
		<input id ="udrtYn">
		<input id ="buldMnnm">
		<input id ="buldSlno">
		<input id ="mtYn">
		<input id ="lnbrMnnm">
		<input id ="lnbrSlno">
		<input id ="emdNo">
	</form>
</body>
</html>