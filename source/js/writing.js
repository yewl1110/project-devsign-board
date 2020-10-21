$(document).ready(function(){
    // input 태그를 통해 파일 선택 창 열어 파일 첨부할 때
    $('#files, #files_sm').change(function(e){
        var files = e.target.files;
        console.log(files);

        if (files.length > 10) {
            alert("파일 개수가 초과되었습니다.(10개 제한)");
            $(this).val("");
            return;
        }else{
            for(var i = 0; i < files.length; i++){
                if(check(files[i])){
                    fileList.push(files[i]);
                }        
            }
            $("#file_info > table").empty();
            if(fileList.length > 0){
                drawUploaded(fileList.length);
                if(typeof(uploadedFiles) != "undefined"){
                    drawUploadedFile(uploadedFiles);
                }
                drawFile(fileList);
            }
        }
    });

    // window.innerWidth 값 구한 후
    // drag & drop 적용 여부
    if(window.innerWidth <= 768){
        $('#file_attach').css('display', 'none');
        $('#file_attach_sm').css('display', 'block');
    }else{
        $('#file_attach').css('display', 'block');
        $('#file_attach_sm').css('display', 'none');
    }

    $(window).on('load resize', function(){
        // 태블릿, 모바일 기기일 때
        if(window.innerWidth <= 768){
            $('#file_attach').css('display', 'none');
            $('#file_attach_sm').css('display', 'block');
        }else{
            $('#file_attach').css('display', 'block');
            $('#file_attach_sm').css('display', 'none');
        }
    });

    // div 누르면 파일 탐색 창 열리게
    // $('#file_attach_sm file_upload').click(function(e){
    //     e.preventDefault();
    //     $('#files_sm').click();
    // });

    $('#btn_submit').click(submitContents);

    $("#drop-area")
    .on('dragenter dragover dragleave drop', preventDefaults, false);

    $("#drop-area")
    .on('dragenter dragover', highlight)
    .on('dragleave drop', unhighlight);
    
    $("#drop-area").on('drop', handleDrop);
    $(".file_upload input").css("display", "none");
    $("#message").attr("draggable", false);

    // 파일 초기화 버튼
    $("#upload_cancel")
    .css("display", "none")
    .attr("draggable", false)
    .click(cancel);

    // 업로드 할 파일 정보 표시하는 테이블
    $("#file_info").css("display", "none");

    drawGuide();
});

var fileList = [];

// 게시글 form submit
function submitContents(){
    var contents = $('#contents').html();
    if(contents == "") return false;
    var params = new URLSearchParams(window.location.search);
    $('#board_id').val(params.get("board_id"));
    $('#contents_submit').text(contents);

    var formData = new FormData($('#submitForm')[0]);
    if(typeof(fileList) != "undefined"){
        fileList.forEach(f => formData.append('files[]', f));
    }

    $.ajax({
        url:"../contents/insert_contents.php",
        data:formData,
        type:'POST',
        processData:false,
        contentType:false,
        cache:false,
        success: function(){
            window.history.back();
        },
        error : function(){
            alert("error");
        }
    });
};

function preventDefaults(e){
    // 태그의 고유 동작 제거
    e.preventDefault();

    // 상위 node로의 이벤트 전파 중단
    e.stopPropagation();
}

function highlight(e){
    $("#drop-area").addClass('highlight');
}

function unhighlight(e){
    $("#drop-area").removeClass('highlight');
}

// 파일 드롭 이벤트
function handleDrop(e){
    var files = e.originalEvent.dataTransfer.files;

    var count = files.length + fileList.length;

    // 이미 업로드 되어있는 파일 있을 때
    if(typeof(uploadedFiles) != "undefined"){
        count += Object.keys(uploadedFiles).length;
    }

    if(count > 10){
        alert("파일 개수가 초과되었습니다.(10개 제한)");
        return;
    }
    for(var i = 0; i < files.length; i++){
        if(check(files[i])){
            fileList.push(files[i]);
        }        
    }
    $("#file_info > table").empty();

    // 첨부파일 목록 테이블 다시 그림
    if(fileList.length > 0){
        drawUploaded(fileList.length);
        if(typeof(uploadedFiles) != "undefined"){
            drawUploadedFile(uploadedFiles);
        }
        drawFile(fileList);
        $('#files').val("");
    }
}

// 파일 형식, 크기 체크
function check(file){
    const extensions = ['jpg', 'jpeg', 'png', 'txt'];
    var extension = file.type.split('/').pop();
    var check = false;

    if(file.size > 5000000){
        return check;
    }
    for (var e of extensions.values()){
        if(e == extension){
            check = true;
            break;
        }
    }
    return check;
}

// 첨부된 파일 갯수 표시
function drawUploaded(count){
    //$("#drop-area").children().first().css("display", "none");
    $("#message").html("<label>" + count + " files Uploaded.</label>").css("display", "block");
    $("#upload_cancel").css("display", "block");
}

// 파일 업로드 전 기본 메시지 출력
function drawGuide(){
    //$("#drop-area").children().first().css("display", "block");
    $("#message").html("").css("display", "none");
    $("#upload_cancel").css("display", "none");
}

// 파일 첨부 시 파일 리스트 테이블 생성
function drawFile(files){
    $("#file_info").css("display", "block");
    var index = 0;
    files.forEach(file => {
        var file_record = '<tr><td style="display:none;"><label>' + index + '</label></td><td style="width: 90%;"><label>' + file.name + '</label></td><td style="width: 10%;"><input class="btn btn-outline-secondary btn-sm" type="button" value="삭제" onclick="removeRow(this)"></td></tr>';
        $("#file_info > table").append(file_record);
        index++;
    });
}

// 첨부된 파일 전체 취소 처리
function cancel(){
    $("#file_info").css("display", "block");
    $("#drop-area input").val('');
    $("#file_info > table").empty();

    // 새로 업로드 할 파일 리스트 초기화
    if(typeof(fileList) != "undefined"){
        fileList = [];
    }

    // 글 수정할 때 이미 업로드 된 파일 모두 삭제 리스트에 넣음
    if(typeof(uploadedFiles) != "undefined"){
        Object.keys(uploadedFiles).forEach(id => {
            removeFileList.push(id);
        });
        uploadedFiles = [];
    }
    drawGuide();
}

function removeRow(row){
    removeFile(row);
}

// 파일 리스트 개별 삭제
function removeFile(row){
    var table = document.querySelector('#file_info').children[0];
    var td = $(row).closest("tr").children()[0];
    var label = $(td).children()[0];
    var index = $(label).html();

    $("#file_info > table").empty();

    // 삭제할 파일이 업로드 안된 파일일 때
    if(index >= 0){
        fileList.splice(index, 1);
    }

    // 파일 개별 삭제 후 파일 목록 테이블 새로 생성
    var cnt = fileList.length;
    if(typeof(uploadedFiles) == "undefined"){
        if(cnt > 0){
            drawUploaded(cnt);
            drawFile(fileList);
        }
    }else{
        cnt += Object.keys(uploadedFiles).length;    
        if(cnt > 0){
            drawUploaded(cnt);
            drawUploadedFile(uploadedFiles);
            drawFile(fileList);
        }
    }
    
    // 남은 파일 없을 때
    if(cnt <= 0){
        drawGuide();
    }
}

// 글 수정 시 업로드 되어 있는 파일 리스트 생성
function drawUploadedFile(files){
    var keys = Object.keys(files);
            
    keys.forEach(key =>{
        var file_record = '<tr><td style="display:none;"><label>' +  '-1' + '</label></td><td style="display:none;"><label>' + key + '</label></td><td style="width: 90%;"><label>' + uploadedFiles[key] + '</label></td><td style="width: 10%;"><input class="btn btn-outline-secondary btn-sm" type="button" value="삭제" onclick="removeUploadedFile(this)"></td></tr>';
        $("#file_info > table").append(file_record);
    });
}

// 글 수정 시 업로드 되어 있는 파일 삭제 처리
function removeUploadedFile(row){
    var td = $(row).closest("tr").children()[1];
    var label = $(td).children()[0];
    var id = $(label).html();
    
    delete uploadedFiles[id];
    removeFileList.push(id);
    console.log(uploadedFiles);

    removeFile(row);
}
