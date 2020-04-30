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