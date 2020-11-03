$(document).ready(function(){
    var params = new URLSearchParams(window.location.search);
    var data = null;
    $.ajax({
        url: "../contents/get_contents.php?board_id=" + params.get("board_id"),
        type: "get",
        dataType: "json",
        async: false,
        success:function(result){
            // 존재하지 않는 board_id일 때
            if(result == "0"){
                window.location.href = "index.php";
            }

            // 게시글과 관련된 정보 가져옴
            data = result["board"][0];
            $("#subject").html(data["subject"]);
            $("#user_id").html(data["user_id"]);
            $(".post-meta").append('<span>조회수: '+data["hits"]+'</span>')
            .append('<span>'+data["reg_date"]+'</span>');
            
            console.log(htmlspecialchars_decode(data["contents"]));
            // contents 내용에서 encode했던 html 태그를 decode 가져온 후 decode 함
            $(".post-contents pre").append(htmlspecialchars_decode(data["contents"]));
            
            // 첨부파일이 있을 때
            files = result["table_attach"];
            if(files.length > 0){
                files.forEach(row => {
                    $(".files").append(writeAttachFile(row));
                });
                $(".files").css("display", "block")
                .children().css("display", "block")
                .children().css("display", "block");
            }
            return false;
        }
    });
    
    $("#btn_edit").click( function(){
        window.location.href = "../contents/edit_content.php?board_id=" + params.get("board_id");
    });
    
    $("#btn_remove").click(
        function(){
            if(confirm("삭제하시겠습니까?")){
                window.location.href = "../contents/delete_contents.php?board_id=" + params.get("board_id");
            }
        }
        );
    });
    
    function writeAttachFile(row){
        var url = "http://hotcat.ddns.net:40080/contents/download.php?download="+row['file_id'];
        return '<span><a href="'+url+'">'+row['file_name_origin']+'</a></span>';
    }
    
    var htmlspecialchars_decode = function(string) {
        
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
            [ '"', '&quot;' ],
            [ '>', '&gt;' ],
            [ '<', '&lt;' ],
            [ '&', '&amp;' ]
        ];