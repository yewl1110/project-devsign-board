document.querySelector('.passwd').addEventListener('keyup', function(){
    var message = document.getElementById('passwd_message');
    var value = document.getElementById('confirm').value;
    var cmp = document.getElementById('passwd').value;
    document.getElementById('btn_submit').disabled = true;
    
    if(cmp.length < 8 || cmp.length > 16){
        message.innerHTML = "비밀번호는 8~16자리여야합니다.";
        message.style.color = "red";
    }
    else if(value != cmp){
        message.innerHTML = "비밀번호가 일치하지않습니다.";
        message.style.color = "red";
    }
    else{
        message.innerHTML = "일치합니다.";
        message.style.color = "green";
        document.getElementById('btn_submit').disabled = false;
    }
});

document.getElementById("files").addEventListener('change', function(){
    var x = document.getElementById("files");
    if ('files' in x) {
        if (x.files.length > 10) {
            alert("파일 개수가 초과되었습니다.(10개 제한)");
            document.getElementById("files").value = "";
            return;
        }
    }
});

function submitContents(){
    var contents = document.getElementById("contents").innerHTML;
    if(contents == "") return false;
    document.getElementById("contents_submit").value = contents;
};