$(document).ready(function(){
    var home = "http://hotcat.ddns.net:40080/pi/project-devsign-board/source";
    $("#message_passwd").css("display", "none");
    var password_check = false;

    
    $("#password, #confirm").keyup(function(){
        password_check = false;
        var password = $("#new_password").val();
        var confirm = $("#confirm").val();
        var reg = /^[a-zA-Z0-9_!@$%^&*,.?]{8,16}$/;

        if(reg.test(password) == false){
            $("#message_passwd").css("display","block").text("비밀번호 형식이 올바르지 않습니다. 8~16자리 (숫자, 영어, _!@$%^&*,.? 사용 가능)");
        }else{
            if(password.length < 8 || confirm.length > 16){
                $("#message_passwd").css("display","inline")
                .text("비밀번호는 8 ~ 16 자리여야 합니다.");
            }else if(password != confirm){
                $("#message_passwd").css("display","inline")
                .text("비밀번호가 일치하지 않습니다.");
            }else{
                $("#message_passwd").css("display","none");
                password_check = true;
            }
        }
    });

    $("#account").submit(function(e){
        var len = $("#new_password").val().length;
        if(!password_check && len > 0){
            alert("새 비밀번호가 올바르지 않습니다.");
        }else{
            e.preventDefault();
            var d = $(this).serializeArray();
            $.ajax({
                type: "POST",
                data: d,
                url:home+"/update_member.php",
                success: function(result){
                    if(result == "-1"){ // 실패
                        alert("비밀번호가 틀립니다.");
                        return false;
                    }
                    else if(result == "-2"){
                        alert("변경 실패");
                        return false;
                    }
                    else{
                        window.location.replace(home + "/index.php?message=ACCOUNT_CHANGE_SUCCESS");
                    }
                }
            });
        }
    })
});