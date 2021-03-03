$(document).ready(function(){
    $("#message-passwd").css("display", "none");
    let password_check = false;
    
    $("#confirm").keyup(function(){
        password_check = false;
        let password = $("#new-password").val();
        let confirm = $("#confirm").val();
        let reg = /^[a-zA-Z0-9_!@$%^&*,.?]{8,16}$/;

        if(reg.test(password) == false){
            $("#message-passwd").css("display","block").text("비밀번호 형식이 올바르지 않습니다. 8~16자리 (숫자, 영어, _!@$%^&*,.? 사용 가능)");
        }else{
            if(password.length < 8 || password.length > 16){
                $("#message-passwd").css("display","block")
                .text("비밀번호는 8 ~ 16 자리여야 합니다.");
            }else if(password != confirm){
                $("#message-passwd").css("display","block")
                .text("비밀번호가 일치하지 않습니다.");
            }else{
                $("#message-passwd").css("display","none");
                password_check = true;
            }
        }
    });

    $("#change-form").submit(function(e){
        e.preventDefault();

        let len = $("#new-password").val().length;
        if(!password_check && len > 0){
            alert("새 비밀번호가 올바르지 않습니다.");
        }else{
            let url = new URL(window.location.href);
            let formData = new FormData($('#change-form')[0]);
            formData.append('email', url.searchParams.get('email'));
            formData.append('email_key', url.searchParams.get('email_key'));

            $.ajax({
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                url:`${window.location.origin}/find/reset-password.php`,
                success: function(result){
                    console.log(result);
                    if(result.success == true){
                        alert("변경되었습니다.")
                        window.location.href = window.location.origin + '/auth/login.php';
                    } else {
                        alert("실패했습니다.");
                        return false;
                    }
                }
            });
        }
    })
});