var confirm_passwd = document.getElementById('confirm');
var message = document.getElementById('passwd_message');

var passwd = document.getElementById('passwd');
passwd.addEventListener("keyup", function(){
    var value = document.getElementById('passwd').value;
    document.getElementById('btn_submit').disabled = true;
    if(value.length < 8 || value.length > 16){
        message.innerHTML = "비밀번호는 8~16자리여야합니다.";
        message.style.color = "red";
    }else{
        message.innerHTML = "";
    }
});

confirm_passwd.addEventListener("keyup", function() {
    var value = document.getElementById('confirm').value;
    var cmp = document.getElementById('passwd').value;
    document.getElementById('btn_submit').disabled = true;
    window.console.log(cmp.length);
    if(cmp.length < 8 || cmp.length > 16){
        message.innerHTML = "비밀번호는 8~16자리여야합니다.";
        message.style.color = "red";W
    }
    else if(value != cmp){
        message.innerHTML = "비밀번호가 일치하지않습니다.";
        message.style.color = "red";
    }
    else{
        message.innerHTML = "일치합니다.";
        message.style.color = "green";
        document.getElementById('btn_submit').disabled = false;
    }});
