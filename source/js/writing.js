$(document).ready(function(){
    $('#files').change(function(e){
        var files = e.target.files;
        console.log(files);

        if (files.length > 10) {
            alert("파일 개수가 초과되었습니다.(10개 제한)");
            $('#files').val("");
            return;
        }else{
            for(var i = 0; i < files.length; i++){
                if(check(files[i])){
                    fileList.push(files[i]);
                }        
            }
            $("#file_info > table").empty();
            drawUploaded(fileList.length);
            if(typeof(uploadedFiles) != "undefined"){
                drawUploadedFile(uploadedFiles);
            }
            drawFile(fileList);
            $('#files').val("");
        }
    });

    $('#btn_submit').click(submitContents);

    $("#drop-area")
    .on('dragenter dragover dragleave drop', preventDefaults, false);

    $("#drop-area")
    .on('dragenter dragover', highlight)
    .on('dragleave drop', unhighlight);
    
    $("#drop-area").on('drop', handleDrop);

    $("#files").css("display", "none");
    $("#upload_cancel")
    .css("position", "relative")
    .css("display", "none")
    .attr("draggable", false)
    .click(cancel);

    $("#message").css("position", "relative");

    $('.file_upload').css('overflow-y', 'auto');

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
        url:"insert_contents.php",
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
    drawUploaded(count);
    if(typeof(uploadedFiles) != "undefined"){
        drawUploadedFile(uploadedFiles);
    }
    drawFile(fileList);
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

// 업로드 될 파일 갯수 표시
function drawUploaded(count){
    $("#drop-area").children().first().css("display", "none");
    $("#message").html("<label>" + count + " files Uploaded.</label>").css("display", "block");
    $("#upload_cancel").css("display", "block");
}

// 파일 업로드 전 기본 메시지 출력
function drawGuide(){
    $("#drop-area").children().first().css("display", "block");
    $("#message").html("").css("display", "none");
    $("#upload_cancel").css("display", "none");
}

// 업로드 시 파일 리스트 생성
function drawFile(files){
    var index = 0;
    files.forEach(file => {
        var file_record = '<tr><td style="display:none;"><label>' + index + '</label></td><td><label>' + file.name + '</label></td><td><label>' + file.size + '</label></td><td><input class="btn btn-secondary btn-sm" type="button" value="삭제" onclick="removeRow(this)"></td></tr>';
        $("#file_info > table").append(file_record);
        index++;
    });
}

// 파일 업로드 취소
function cancel(){
    $("#drop-area input").val('');
    $("#file_info > table").empty();
    if(typeof(fileList) != "undefined"){
        fileList = [];
    }
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
    if(cnt <= 0){
        drawGuide();
    }
}

// 기존 파일 리스트 생성
function drawUploadedFile(files){
    var keys = Object.keys(files);
            
    keys.forEach(key =>{
        var file_record = '<tr><td style="display:none;"><label>' +  '-1' + '</label></td><td style="display:none;"><label>' + key + '</label></td><td><label>' + files[key] + '</label></td><td><label>' + 0 + '</label></td><td><input class="btn btn-secondary btn-sm" type="button" value="삭제" onclick="removeUploadedFile(this)"></td></tr>';
        $("#file_info > table").append(file_record);
    });
}

function removeUploadedFile(row){
    var td = $(row).closest("tr").children()[1];
    var label = $(td).children()[0];
    var id = $(label).html();
    
    delete uploadedFiles[id];
    removeFileList.push(id);
    console.log(uploadedFiles);

    removeFile(row);
}
