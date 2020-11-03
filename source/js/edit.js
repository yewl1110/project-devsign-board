$(document).ready(function () {
    var params = new URLSearchParams(window.location.search);
    var data = null;

    // board_id로 게시글 내용 로드
    $.ajax({
        url: "../contents/get_contents.php?board_id=" + params.get("board_id"),
        type: "get",
        dataType: "json",
        async: false,
        success: function (result) {
            if (result == "0") {
                window.location.href = "index.php";
            }
            data = result["board"][0];
            result["table_attach"].forEach(file => {
                uploadedFiles[file["file_id"]] = file["file_name_origin"];
            });
            $("#subject").val(data["subject"]);
            $('#contents_submit').val(htmlspecialchars_decode(data["contents"]));

            // 게시글에 첨부된 파일 있을 때
            var keys = Object.keys(uploadedFiles);
            if (keys.length > 0) {
                $('#file_info').css("display", "block");
                drawUploaded(keys.length);
                keys.forEach(key => {
                    var file_record = '<tr><td style="display:none;"><label>-1</label></td><td style="display:none;">' +
                            '<label>' + key + '</label></td><td style="width: 90%;"><label>' +
                            uploadedFiles[key] + '</label></td><td style="width: 10%;"><input class="btn btn-outline-secondary btn-sm" type="button" value="삭제" onclick="removeUploadedFile(this)' +
                            '"></td></tr>';
                    $("#file_info > table").append(file_record);
                });
            }
            return false;
        }
    });

    $('#board_id').css('display', 'none');

    // 기존의 클릭 이벤트 (게시글 등록) 제거 새로운 클릭 이벤트 등록 (게시글 내용 업데이트)
    $('#btn_submit').off('click');
    $('#btn_submit').click(updateContents);
});

// 삭제할 파일 리스트
var removeFileList = [];
// 새로 첨부된 파일 리스트
var uploadedFiles = [];

function updateContents() {
    // 글 내용 없으면 업로드 안됨
    if($('#contents_submit').val() == "") return false;

    var params = new URLSearchParams(window.location.search);

    // db 업데이트 위한 key 보냄
    $('#board_id').val(params.get("board_id"));

    var formData = new FormData($('#submitForm')[0]);
    if (typeof(fileList) != "undefined") {
        fileList.forEach(f => formData.append('files[]', f));
    }
    if (typeof(removeFileList) != "undefined") {
        removeFileList.forEach(id => formData.append('removeFiles[]', id));
    }

    $.ajax({
        url: "../contents/update_contents.php",
        data: formData,
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function () {
            window.history.back();
        },
        error: function () {
            alert("error");s
        }
    });
};

function writeAttachFile(row) {
    var url = "http://hotcat.ddns.net:40080/pi/project-devsign-board/source/download.php?down" +
            "load=" + row['file_name_save'];
    return '<span><a href="' + url + '">' + row['file_name_origin'] +
            '</a></span>';
}

var htmlspecialchars_decode = function (string) {

    // Our finalized string will start out as a copy of the initial string.
    var unescapedString = string;

    // For each of the special characters,
    var len = htmlspecialchars_decode.specialchars.length;
    for (var x = 0; x < len; x++) {

        // Replace all instances of the entity with the special character.
        unescapedString = unescapedString.replace(
            new RegExp(htmlspecialchars_decode.specialchars[x][1], 'g'),
            htmlspecialchars_decode.specialchars[x][0]
        );
    }

    // Return the unescaped string.
    return unescapedString;
};

htmlspecialchars_decode.specialchars = [
    [
        '"', '&quot;'
    ],
    [
        '>', '&gt;'
    ],
    [
        '<', '&lt;'
    ],
    [
        '&', '&amp;'
    ]
];
/*
// 파일 리스트 개별 삭제
function removeFile(row){
    var table = document.querySelector('#file_info').children[0];
    var td = $(row).closest("tr").children()[0];
    var label = $(td).children()[0];
    var index = $(label).html();

    if(index >= 0){
        fileList.splice(index, 1);
    }
    var cnt = fileList.length + Object.keys(uploadedFiles).length;
    $("#file_info > table").empty();
    drawGuide();

    console.log(removeFileList);
}*/