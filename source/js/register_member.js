$(document).ready(function(){
    var id_check = false;
    var password_check = false;
    var email_check = false;

    $("#value_id").keyup(function(){
        $("#value_id").removeClass("is-vaild").addClass("is-invaild");
        $("#message_id").text("");
        id_check = false;
    });

    $("#check_id").click(function(){
        id_check = false;
        var value = $("#value_id").val();
        var reg = /^[a-zA-Z0-9_]{5,15}$/;

        if(reg.test(value) == false){
            $("#value_id").removeClass("is-vaild").addClass("is-invaild");
            $("#message_id").html("ID 형식이 올바르지 않습니다.<br>(5~15자, 알파벳, 숫자, _만 사용 가능)");
        }else{
            $.ajax({
                url:"http://hotcat.ddns.net:40080/pi/project-devsign-board/source/check.php?id="+value,
                type:"get",
                success:function(result){
                    if(result == "0"){
                        $("#value_id").removeClass("is-invaild").addClass("is-vaild");
                        id_check = true;
                    }else{
                        $("#value_id").removeClass("is-vaild").addClass("is-invaild");
                        $("#message_id").text("중복된 ID입니다.");
                    }
                },
                error:function(){
                    alert($.post().error());
                }
            });
        }
        return false;
    });

    $("#value_email").keyup(function(){
        $("#value_email").removeClass("is-vaild").addClass("is-invaild");
        $("#message_email").text("");
        email_check = false;
    });

    $("#check_email").click(function(){
        email_check = false;
        var value = $("#value_email").val();
        var reg = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
        
        if(reg.test(value) == false){
            $("#value_email").removeClass("is-vaild").addClass("is-invaild");
            $("#message_email").text("이메일 형식이 올바르지 않습니다.");
        }
        else{
            $.ajax({
                url:"http://hotcat.ddns.net:40080/pi/project-devsign-board/source/check.php?email="+value,
                type:"get",
                success:function(result){
                    if(result == "0"){
                        $("#value_email").removeClass("is-invaild").addClass("is-vaild");
                        email_check = true;
                    }else{
                        $("#value_email").removeClass("is-vaild").addClass("is-invaild");
                        $("#message_email").text("중복된 이메일 입니다.");
                    }
                },
                error:function(){
                    alert($.post().error());
                }
            });
        }
        return false;
    });

    $("#passwd, #confirm").keyup(function(){
        $("#passwd").removeClass("is-valid").addClass("is-invaild");
        $("#confirm").removeClass("is-valid").addClass("is-invaild");
        password_check = false;
        var password = $("#passwd").val();
        var confirm = $("#confirm").val();
        var reg = /^[a-zA-Z0-9_!@$%^&*,.?]{8,16}$/;

        if(reg.test(password) == false){
            $("#passwd").removeClass("is-valid").addClass("is-invaild");
            $("#message_passwd").html("비밀번호 형식이 올바르지 않습니다.<br> (숫자, 영어, _!@$%^&*,.? 사용 가능)");
        }else{
            if(password.length < 8 || confirm.length > 16){
                $("#passwd").removeClass("is-valid").addClass("is-invaild");
                $("#message_passwd").text("비밀번호는 8 ~ 16 자리여야 합니다.");
            }else if(password != confirm){
                $("#confirm").removeClass("is-valid").addClass("is-invaild");
                $("#message_confirm").text("비밀번호가 일치하지 않습니다.");
            }else{
                $("#passwd").removeClass("is-invalid").addClass("is-vaild");
                $("#confirm").removeClass("is-invalid").addClass("is-vaild");
                $("#message_passwd").text("일치합니다.");
                password_check = true;
            }
        }
    });

    $("form").submit(function(e){
        if(check("ID", id_check) && check("비밀번호", password_check) && check("이메일", email_check)){
            return true;
        }else{
            return false;
        }
    });

    function check(str, val){
        if(!val){
            alert(str + "을 확인하세요.");
        }
        return val;
    }
});
