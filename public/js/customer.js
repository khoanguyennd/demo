$(document).ready(function(){ 
    function getMessage(){
        language = $("#language").val(); 
        if (language == 'EN') {
            return  {
                name: "Please enter your name",
                phone: "Please enter your phone number",
                point: "Please enter numberic and numberic > 0",
            }
        }
        if (language == 'VN') {
            return {
                name: "Vui lòng nhập tên của bạn",
                phone: "Vui lòng nhập số điện thoại của bạn",
                point: "Vui lòng nhập số và số lớn hơn 0",
            }
        }
        if (language == 'KR') {
            return {
                name: "이름을 입력하세요",
                phone: "전화 번호를 입력하세요",
                point: "0보다 큰 숫자와 숫자를 입력하세요",
            }
        }
        return {
            name: "Please enter your name",
            phone: "Please enter your phone number",
            point: "Please enter numberic and numberic > 0",
        }
        
    }
   
  
    $('#btnRegister').on('click', function() {    
        if(!$("#registerForm").valid()) return false;
        $('.div_load_alert').css("display", "block");   
        var userName = $("#userName").val();
        var phone = $("#phone").val();
        var point = $("#point").val();
        if(point =='') point = 0;

        var url = $baseUrl + '/registerUser.html'; 

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name:userName,
                phone:phone,
                point:point
            },
            dataType:'text',
            success:function(data){   
                $('.div_load_alert').css("display", "none");           
                jsonData =  $.parseJSON(data);
                if(jsonData.status == false){
                    $("#msg_err_home").html(jsonData.msg);                                    
                    return false;
                } else {
                    document.getElementById("userName").value="";
                    document.getElementById("phone").value="";
                    document.getElementById("point").value="";
                    $('#dangkytvModal').modal('hide');
                    $('#successContent').text(jsonData.msg);
                    $('#thongbaoModal').modal('show');
                    $("#totalUser").html(jsonData.total);
                    $(".home_totalmember").html(jsonData.total);
                    $('.tv_rows:first-child').before(jsonData.adduser);
                    $('.keyboard').css("display","none");
                    $("#msg_err_home").html(jsonData.msg);                                      
                    
                }
            }
        });
    });
    $('#btnRegister_close').on('click', function() {       
        document.getElementById("userName").value="";
        document.getElementById("phone").value="";
        document.getElementById("point").value="";
       
        $('.keyboard_register').addClass('keyboard--hidden_register');
        $('#dangkytvModal').modal('hide');
    });
    
    $('#btnRegistersetting').on('click', function() {
        if(!$("#registerFormsetting").valid()) return false;
        $('.div_load_alert').css("display", "block");  
        var userName = $("#userNamesetting").val();
        var email = $("#emailsetting").val();
        var point = $("#pointsetting").val();
        if(point =='') point = 0;
        var url = $baseUrl + '/registersettingUser.html'; 

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name:userName,
                email:email,
                point:point
            },
            dataType:'text',
            success:function(data){      
                $('.div_load_alert').css("display", "none");        	
                jsonData =  $.parseJSON(data);
                if(jsonData.status == false){
                    $("#msg_err").html(jsonData.msg);                                     
                    return false;
                } else {
                    document.getElementById("userNamesetting").value="";
                    document.getElementById("emailsetting").value="";
                    document.getElementById("pointsetting").value=""; 
                    $("#msg_err").html(jsonData.msg);
                    $(".number_clb").html(jsonData.total);
                    $('.tv_rows:first-child').before(jsonData.adduser);
                    $('.keyboard').css("display","none");                                   
                    setTimeout(function() { $('#registersettingModal').modal('hide'); }, 2200);
                }
            }
        });

    });
    $('#btnRegistersetting_close').on('click', function() {
        $('.keyboard_registersetting').addClass('keyboard--hidden_registersetting');
        $('#registersettingModal').modal('hide');
    });
    $('#btnRegisterlistmember').on('click', function() {
        if(!$("#registerFormlistmember").valid()) return false;        
        $('.div_load_alert').css("display", "block");  
        var userName = $("#userNamelistmember").val();
        var phone = $("#phonelistmember").val();
        var point = $("#pointlistmember").val();
        if(point =='') point = 0;
        var url = $baseUrl + '/registerlistmemberUser.html'; 

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name:userName,
                phone:phone,
                point:point
            },
            dataType:'text',
            success:function(data){       
                $('.div_load_alert').css("display", "none");       	
                jsonData =  $.parseJSON(data);
                if(jsonData.status == false){                    
                    $("#msg_err_listmember").html(jsonData.msg);                                       
                    return false;
                } else {
                    document.getElementById("userName").value="";
                    document.getElementById("phone").value="";
                    document.getElementById("point").value="";
                    $('#dangkytvModal_ds').modal('hide');
                    $('#successContent').text(jsonData.msg);
                    $('#thongbaoModal').modal('show');
                    $("#totalUser").html(jsonData.total);
                    $('.tv_rows:first-child').before(jsonData.adduser);
                    $('.keyboard').css("display","none");
                    $("#msg_err_home").html(jsonData.msg);                                      
                    
                }
            }
        });

    });
    $('#btnRegisterlistmember_close').on('click', function() {
        $('.keyboard_register_listmember').addClass('keyboard--hidden_register_listmember');
        $('#dangkytvModal_ds').modal('hide');
    });
    // ajax sua thanh vien
    $('#btnEditlistmember').on('click', function() {
        if(!$("#editFormlistmember").valid()) return false;        
        $('.div_load_alert').css("display", "block");   
        var userName = $("#editUserNamelistmember").val();
        var point = $("#editPointlistmember").val();
        var phone = $("#editPhonelistmember").val();
        var id = $("#memberId").val();
        if(point =='') point = 0;
        var url = $baseUrl + '/editlistmemberUser.html'; 

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name:userName,
                phone:phone,
                point:point,
                id:id
            },
            dataType:'text',
            success:function(data){                     
                $('.div_load_alert').css("display", "none");               	
                jsonData =  $.parseJSON(data);
                if(jsonData.status == false){                    
                    $("#msg_err_edit_member").html(jsonData.msg);                        
                    return false;
                } else {
                    document.getElementById("infoUserNamelistmember").value="";
                    document.getElementById("infoPhonelistmember").value="";
                    document.getElementById("infoPointlistmember").value=""; 
                    document.getElementById("editUserNamelistmember").value="";
                    document.getElementById("editPhonelistmember").value="";
                    document.getElementById("editPointlistmember").value="";
      
                    $('#suatvModal_ds').modal('hide'); 
                    $('#tttvModal_ds').modal('hide');
                    $('#successContent').text(jsonData.msg);               
                    $("#totalUser").html(jsonData.total);
                    $('.tv_rows:first-child').before(jsonData.adduser);
                    $('.keyboard').css("display","none");
                    $("#msg_err_home").html(jsonData.msg);                                      
                  
                    $('#seachMember').click();

                    $('#thongbaoModal').modal('show');
                    
                }
            }
        });

    });
    $('#btnEditlistmember_close').on('click', function() {
        $('.keyboard_register_listmember').addClass('keyboard--hidden_register_listmember');
        $('#suatvModal_ds').modal('hide');
    });

    $("#registerForm").validate({
    	rules: {
    		name: {
                required: true,
                normalizer: function( value ) {
                    return $.trim( value );
                  }
            },
    		phone:{
                        required: true,
                },
                point:{
                        required: true,
                        number: true,
                        min: 1
                }
    	},
            messages: getMessage()
    })
    $("#registerFormsetting").validate({
    	rules: {
    		name: {
                required: true,
                normalizer: function( value ) {
                    return $.trim( value );
                  }
            },
    		email: {
                        required: true,
                        email: true
                },
                point:{
                    required: true,
                        number: true,
                        min: 1
                }
    	},
            messages: getMessage()
    })
    
    $("#registerFormlistmember").validate({
    	rules: {
    		name: {
                required: true,
                normalizer: function( value ) {
                    return $.trim( value );
                  }
            },
    		phone: {
                        required: true
                },
                point:{
                    required: true,
                        number: true,
                        min: 1
                }
    	},
            messages: getMessage()
    })

    $("#editFormlistmember").validate({
    	rules: {
    		name: {
                required: true,
                normalizer: function( value ) {
                    return $.trim( value );
                  }
            },
    		phone: {
                        required: true
                },
                point:{
                    required: true,
                        number: true,
                        min: 1
                }
    	},
            messages: getMessage()
    })
})