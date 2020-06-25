$(document).ready(function(){
    $('#files').change(function(){
        console.log("change");
        var x = $('#files');
        if ('files' in x) {
            if (x.files.length > 10) {
                alert("파일 개수가 초과되었습니다.(10개 제한)");
                $('#files').val("");
                return;
            }
        }
    });

    $("#drop-area")
    .on('dragenter dragover dragleave drop', preventDefaults, false);

    $("#drop-area")
    .on('dragenter dragover', highlight)
    .on('dragleave drop', unhighlight);
    
    $("#drop-area").on('drop', handleDrop);

    $("#files").css("display", "none");
    $("#upload_cancel")
    .css("display", "none")
    .attr("draggable", false)
    .click(cancel);

    drawGuide();
});

function submitContents(){
    var contents = $('#contents').html();
    if(contents == "") return false;
    var params = new URLSearchParams(window.location.search);
    $('#board_id').val(params.get("board_id"));
    $('#contents_submit').text(contents);
};

function preventDefaults(e){
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e){
    $("#drop-area").addClass('highlight');
}

function unhighlight(e){
    $("#drop-area").removeClass('highlight');
}

function handleDrop(e){
    var files = e.originalEvent.dataTransfer.files;
    var count = 0;
    console.log(files);
    if(files.length > 10){
        alert("파일 개수가 초과되었습니다.(10개 제한)");
        return;
    }
    for(var i = 0; i < files.length; i++){
        if(check(files[i])){
            uploadFile(files[i]);
        }        
        count++;
    }
    drawUploaded(count);
}

function uploadFile(file){
    var formData = new FormData();
    formData.append('file', file);

    fetch('.', {
        method: 'POST',
        body: formData
    })
    .then();
}

function check(file){
    const extensions = ['jpg', 'jpeg', 'png', 'txt'];
    var extension = file.type.split('/').pop();
    var check = false;

    console.log(extension);
    if(file.size > 5000000){
        return check;
    }
    for(var i=0;i<extensions.length;i++){
        if(extensions == extension){
            check = true;
            break;
        }
    }
    return check;
}

function drawUploaded(count){
    $("#drop-area label").css("display", "none");
    $("#message").html("<label>" + count + " files Uploaded.</label>").css("display", "inline-block");
    $("#upload_cancel").css("display", "block");
}

function drawGuide(){
    $("#drop-area label").css("display", "block");
    $("#message").html("").css("display", "none");
    $("#upload_cancel").css("display", "none");
}

function cancel(){
    $("#drop-area input").val('');
    drawGuide();
}