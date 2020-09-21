$(document).ready(function () {
    /*var amt_contents = document.getElementById("amt_contents");
    var value = getCookie("amt_contents");
    if(value){
        for(var j, i = 0; j = amt_contents.options[i]; i++){
            if(value == j.value){
                amt_contents.selectedIndex = i;
                break;
            }
        }
    }*/

    /*document.getElementById("amt_contents").addEventListener('change', function(){
        var value = document.getElementById("amt_contents").value;
        var date = new Date();
        date.setTime(date.getTime() + 24*60*60*1000);
        document.cookie = "amt_contents=" + value + ";expires=" + date.toUTCString() + ";path=/";
        location.reload();
    });*/
    history.pushState('', '.');
    var table = fetch_data();
    // $(".top").css("display", "inline-block") .css("width", "100%"); $(".top
    // .dt-buttons").css("float", "right");

    $('.top')
        .addClass('row')
        .addClass('justify-content-between');

    $('#tb')
        .addClass('col-12')
        .css('width', '100%');
    $("#tb tbody").on('click', 'tr', function () {
        var data = table.row(this).data();
        // label 태그 제거
        var board_id = data[0].replace( /(<([^>]+)>)/ig, '');
        window
            .location
            .replace("view.php?board_id=" + board_id);
    });

    $("#btn_search").on('click', function () {
        var val = $("#search_mode").val();
        var keyword = $("#keyword").val();
        table.destroy();
        table = fetch_data(val, keyword);
    })
});

function getNum(value) {
    window
        .location
        .replace("./writing.php");
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document
        .cookie
        .split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') 
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) 
            return c.substring(nameEQ.length, c.length);
        }
    return null;
}

function fetch_data(mode = '', keyword = '') {
    var table = $("#tb").DataTable({
        ajax: {
            url: "../script/fetch.php",
            type: "POST",
            data: {
                mode: mode,
                keyword: keyword
            }
        },
        buttons: [
            {
                text: '글쓰기',
                action: function (e, dt, node, config) {
                    window
                        .location
                        .replace("./writing.php");
                }
            }
        ],
        columnDefs: [
            {
                className: "tb_title",
                targets: [1]
            },
            {
                className: "tb_hits",
                targets: [3]
            },
            {
                className: "tb_date",
                targets: [4]
            }
        ],
        dom: '<"top"lB>t<"page"p>',
        info: false,
        lengthMenu: [
            30, 50
        ],
        ordering: false,
        paging: true,
        pagingType: "simple_numbers",
        processing: true,
        searching: false,
        serverSide: true
    });
    return table;
}