document.getElementById("amt_contents").addEventListener('change', function(){
    var value = document.getElementById("amt_contents").value;
    var date = new Date();
    date.setTime(date.getTime() + 24*60*60*1000);
    document.cookie = "amt_contents=" + value + ";expires=" + date.toUTCString() + ";path=/";
    location.reload();
});

function getNum(value){
    alert(value);
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') 
            c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) 
            return c.substring(nameEQ.length,c.length);
    }
    return null;
}

var amt_contents = document.getElementById("amt_contents");
var value = getCookie("amt_contents");
if(value){
    for(var j, i = 0; j = amt_contents.options[i]; i++){
        if(value == j.value){
            amt_contents.selectedIndex = i;
            break;
        }
    }
}