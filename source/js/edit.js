$(document).ready(function(){
    var params = new URLSearchParams(window.location.search);
    var data = null;
    $.ajax({
        url: "get_contents.php?board_id=" + params.get("board_id"),
        type: "get",
        dataType: "json",
        async: false,
        success:function(result){
            if(result == "0"){
                window.location.href = "index.php";
            }
            data = result["board"][0];
            contents = result["table_attach"];
            console.log(result);
            $("#subject").val(data["subject"]);
            
            $("#contents").html(htmlspecialchars_decode(data["contents"]));
            
            if(contents.length > 0){
                contents.forEach(row => {
                    $(".files").append(writeAttachFile(row));
                });
            }
            return false;
        }
    });
    
});

function writeAttachFile(row){
    var url = "http://hotcat.ddns.net:40080/pi/project-devsign-board/source/download.php?download="+row['file_name_save'];
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