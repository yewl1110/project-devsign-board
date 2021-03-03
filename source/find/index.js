$(document).ready(function() {
    let regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;

    $('#find-id-form').on('submit', function(e) {
        e.preventDefault();

        let email = $('#find-id-email').val();
        if(email != "" && regExp.test(email)) {
            let formData = new FormData($('#find-id-form')[0]);
            $.ajax({
                url:`${window.location.origin}/find/find-id.php`,
                data: formData,
                type:'POST',
                processData:false,
                contentType:false,
                cache:false,
                success: function(result){
                    if(result.success == false) {
                        alert('등록되지 않은 이메일입니다.');
                    } else {
                        alert('이메일을 확인하세요.')
                        window.location.href = window.location.origin + '/auth/login.php';
                    }
                },
                error : function(){
                    alert("error");
                }
            });
        }
    });

    $('#find-password-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#find-pw-id').val();
        let email = $('#find-pw-email').val();
        if(id != "" && email != "" && regExp.test(email)) {
            let formData = new FormData($('#find-password-form')[0]);
            $.ajax({
                url:`${window.location.origin}/find/find-password.php`,
                data: formData,
                type:'POST',
                processData:false,
                contentType:false,
                cache:false,
                success: function(result){
                    console.log(result);
                    if(result.success == false) {
                        alert('등록되지 않은 정보입니다.');
                    } else {
                        alert('이메일을 확인하세요.');
                        window.location.href = window.location.origin + '/auth/login.php';
                    }
                },
                error : function(){
                    alert("error");
                }
            });
        }
    });
});
