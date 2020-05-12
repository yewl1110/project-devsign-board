$(document).ready(function(){
    $('#files').change(function(){
        var x = $('#files');
        if ('files' in x) {
            if (x.files.length > 10) {
                alert("파일 개수가 초과되었습니다.(10개 제한)");
                $('#files').val("");
                return;
            }
        }
    });
});

function submitContents(){
    var contents = $('#contents').html();
    if(contents == "") return false;
    var params = new URLSearchParams(window.location.search);
    $('#board_id').val(params.get("board_id"));
    $('#contents_submit').text(contents);
};