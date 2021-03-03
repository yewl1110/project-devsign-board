let board_id = '';
let last_id = '';

$(document).ready(function () {
    var params = new URLSearchParams(window.location.search);
    var data = null;
    window.history.replaceState(null, null, window.location.pathname);

    $.ajax({
        url: `/contents/get_contents.php?board_id=${params.get("board_id")}`,
        type: "get",
        dataType: "json",
        async: false,
        success: function (result) {
            // 존재하지 않는 board_id일 때
            if (result == "0") {
                window.location.href = "index.php";
            }

            // 게시글과 관련된 정보 가져옴
            data = result["board"][0];
            board_id = data["board_id"];
            $("#board_id").val(data["board_id"]);
            $("#subject").html(data["subject"]);
            $("#user_id").html(data["user_id"]);
            $(".post-meta")
                .append('<span>조회수: ' + data["hits"] + '</span>')
                .append('<span>' + data["reg_date"] + '</span>');

            // contents 내용에서 encode했던 html 태그를 decode 가져온 후 decode 함
            $(".post-contents pre").append(htmlspecialchars_decode(data["contents"]));

            // 첨부파일이 있을 때
            files = result["table_attach"];
            if (files.length > 0) {
                files.forEach(row => {
                    $(".files").append(writeAttachFile(row));
                });
                $(".files")
                    .css("display", "block")
                    .children()
                    .css("display", "block")
                    .children()
                    .css("display", "block");
            }

            setInterval(getNewComments, 10000, board_id, last_id);

            return false;
        }
    });

    $("#btn_edit").click(function () {
        window.location.href = "/contents/edit_content.php?board_id=" + params.get(
            "board_id"
        );
    });

    $("#btn_remove").click(function () {
        if (confirm("삭제하시겠습니까?")) {
            window.location.href = "/contents/delete_contents.php?board_id=" + params.get(
                "board_id"
            );
        }
    });
    
    getComments(0);
    last_id = $('#comments').children().first().attr('id');

    $('#submit-form').on('submit', insertComments);

    $('#comment-btn').click(function() {
        var index = $('#comments').children().last().attr('id');
        getComments(index);
    });
    
});

function writeAttachFile(row) {
    var url = `${window.location.origin}/contents/download.php?download=${row['file_id']}`;
    return `<span><a href="${url}">${row['file_name_origin']}</a></span>`;
}

function writeComments(row) {
    // var edit_tag = (row['edit']) ? `<span class="comment-edit"><a onclick="">수정</a> <a onclick="deleteComments(${row['comment_id']})">삭제</a></span>` : '';
    var edit_tag = (row['edit']) ? 
    `<span class="comment-edit">
        <a href="javascript:void(0);" onclick="updateComments(${row['comment_id']})">수정</a> 
        <a href="javascript:void(0);" onclick="deleteComments(${row['comment_id']})">삭제</a>
    </span>` : '';
    return `
    <div class="comment" id="${row['comment_id']}">
        <div>
            <span class="comment_id" style="display:none;">${row['comment_id']}</span>
            <span class="user-id">${row['user_id']}</span> 
            <span class="comment-time">${row['reg_date']}</span>${edit_tag}</div>
        <div class="comment-contents">
            <textarea class="form-control" readonly>${row['contents']}</textarea>
        </div>
    </div>`;
}

function getComments(index) {
    $.ajax({
        url: `${window.location.origin}/contents/get_comments.php?board_id=${board_id}&index=${index}`,
        type: "get",
        dataType: "json",
        async: false,
        success: function (result) {
            // 존재하지 않는 board_id일 때
            if (result == "0") {
                $('#comment-btn').off('click').remove();
                return;
            }
            
            result.forEach(function(row) {
                $('#comments').append(writeComments(row));
            });

            // if(result.length < 15){
            //     $('#comment-btn').off('click').remove();
            // }
            return false;
        }
    });
}

function insertComments() {
    if($('#submit-form textarea').val() == '') {
        return;
    }

    var formData = new FormData();
    formData.append('board_id', board_id);
    formData.append('contents', $('#submit-form textarea').val());
    
    $.ajax({
        url: `/contents/insert_comments.php`,
        contentType: false,
        data: formData,
        type: "post",
        processData:false, 
        success: function (result) {
            var obj = Object.assign(JSON.parse(result), { 'contents' : $('#submit-form textarea').val() });
            $('#submit-form textarea').val('');
            $('#submit-form textarea').change();
            $('#comments').prepend(writeComments(obj));

            var textarea = $('#comments').find(`div#${obj.comment_id}`).find('textarea');
            $(textarea).on('change input', function () {
                this.style.height = "";
                this.style.height = this.scrollHeight + "px";
            });
            $(textarea).change();
            return false;
        }
    });
}

function updateComments(comment_id){
    var textarea = $(`#${comment_id} .comment-contents textarea`);

    if($(textarea).hasClass('editable')){
        if($(textarea).val() == '') {
            return;
        }
        var formData = new FormData();
        formData.append('board_id', board_id);
        formData.append('comment_id', comment_id);
        formData.append('contents', $(textarea).val());
        
        $.ajax({
            url: '/contents/update_comments.php',
            contentType : false,
            data: formData,
            type: "post",
            async: true,
            processData: false,            
            success: function (result) {
                $('.comment-contents textarea').attr('readonly', true)
                .removeClass('editable');
                return false;
            }
        });
    } else {
        $('.comment-contents textarea').attr('readonly', true)
        .removeClass('editable');
        $(textarea).attr('readonly', false)
        .addClass('editable');
    }
}

function deleteComments(comment_id){
    // var comment_id = $(e).closest('div').find('.comment_id').html();
    if (confirm("댓글을 삭제하시겠습니까?")) {
        $.ajax({
            url: `../contents/delete_comments.php?comment_id=${comment_id}`,
            type: "get",
            dataType: "json",
            async: true,
            success: function (result) {
                $(`#${comment_id}`).remove();
                return false;
            }
        });
    }
}

// 실시간으로 작성되는 댓글 가져오기
function getNewComments(board_id) {
    $.ajax({
        url: `../contents/fetch_new_comments.php?board_id=${board_id}&index=${last_id}`,
        type: "get",
        dataType: "json",
        async: false,
        success: function (result) {
            // 존재하지 않는 board_id일 때
            if (result == "0") {
                return;
            }
            
            result.forEach(function(row) {
                $('#comments').prepend(writeComments(row));
            });

            last_id = $('#comments').children().first().attr('id');
            return false;
        }
    });
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