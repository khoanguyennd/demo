$(document).ready(function(){
	
	$('body').on('click', '.add_diemchodoithubk', function(){
		$.blockUI();
		var dataId =$(this).attr('data-id');
		var user1 = document.getElementById("user1").value;
        var user2 = document.getElementById("user2").value;
		if(dataId == user1){
			var otherUser = user2;
		} else {
			var otherUser = user1;
		}
		var endPointUser = $("#pointEndUser" + dataId).val();
		var currentPointUser = $("#pointCurrentUser" + dataId).val();
		var currentAddPoint = $('#oneAddPoint').val();
		var nextPoint = parseInt(currentAddPoint) + 1;
		var TotalPoint = nextPoint + parseInt(currentPointUser);
		if(parseInt(endPointUser) > parseInt(TotalPoint)){			
			var timeUser = $('#timeUser').val();			
			$('.rowshowPoint' + dataId).html(nextPoint);
			$('.rowshowTime' + dataId).html(timeUser);				
			if(TotalPoint < 10) TotalPoint = '0' + parseInt(TotalPoint);
			$('#point' + dataId).html(TotalPoint); 
			$('#oneAddPoint').val(nextPoint);
		}
		
		if(endPointUser == TotalPoint){
			$.unblockUI();
			if(TotalPoint < 10) TotalPoint = '0' + parseInt(TotalPoint);
			$('#point' + dataId).html(TotalPoint); 
			$('#oneAddPoint').val(nextPoint);			
			$(".button_tranfer").trigger("click");			
			return false;
		}						
		$.unblockUI(); 
	})
})