let index = 0;

if($('#notification').length > 0 && $('#m-notification').length > 0) {

    $('.noti-contents').on('scroll', function() {
        let scrollTop = $('.noti-contents').scrollTop();
        let divHeight = $('.noti-contents').height();
        let fullHeight = $('.noti-contents').prop('scrollHeight');
        if(scrollTop + divHeight == fullHeight) {
            getNotification();
        }
    });
    
    $(document).on('click', '.noti-title > p', function(e) {
        e.stopPropagation();
        clearAllNotifications();
    });
    
    $(document).on('click', '.dropdown-item > p', function(e) {
        e.stopPropagation();
        clearNotification($(this).attr('id'));
    });

    $(document).on('click', '.dropdown-item', function(e) {
        e.stopPropagation();
        window.location.href = `${window.location.origin}/contents/view.php?board_id=${$(this).children('.board-id').html()}`;
    });
    
    getNotification();
    
    let alarm = setInterval(getNewNotification, 10000);

    $(window).on('resize', function() {
        if($(window).outerWidth() >= 992) {
        // if(window.innerWidth >= 992) {
            $('#m-notification').closest('.nav-item').css('display', 'none');
            $('#notification').closest('.nav-item').css('display', 'initial');
            $('#m-notification').closest('.navbar').css('width', '0px');
        } else {
            let width = $('nav').width() - ($('.navbar-brand').width() + $('.navbar-toggler').outerWidth() + 50);
            width += 'px';
            $('#m-notification').closest('.nav-item').css('display', 'initial');
            $('#notification').closest('.nav-item').css('display', 'none');
            $('#m-notification').closest('.navbar').css('width', width);
        }
    });

    $(window).trigger('resize');
}
    
function getNotification() {
    $.ajax({
        url: `${window.location.origin}/notification.php?index=${index}`,
        method: 'GET',
        success: function(result) {
            if(result != '0') {
                index++;
                let data = JSON.parse(result);
                if(data.length > 0) {
                    $.each(data, function(i, item) {
                        $('.noti-contents').append(createNotiRow(item));
                    });
                } else {
                    $('.noti-contents').off('scroll');
                }
            }
        }
    });
}

function getNewNotification() {
    let lastId = 0;
    if($('.dropdown-item').length > 0) {
        let el = $('.noti-contents').children().first();
        lastId = $(el).children('p').first().prop('id');
    }
    
    $.ajax({
        url: `${window.location.origin}/notification.php?index=0&last_id=${lastId}`,
        method: 'GET',
        success: function(result) {
            if(result != '0') {
                let data = JSON.parse(result);
                if(data.length > 0) {
                    $.each(data, function(i, item) {
                        $('.noti-contents').prepend(createNotiRow(item));
                    });
                }
            }
        }
    });
}

function clearNotification(id) {
    $.ajax({
        url: `${window.location.origin}/delete_notification.php?id=${id}`,
        method: 'GET',
        success: function(data) {
            $(`#notification p#${id}`).closest('button.dropdown-item').remove();
            $(`#m-notification p#${id}`).closest('button.dropdown-item').remove();
        }
    });
}

function clearAllNotifications() {
    $.ajax({
        url: `${window.location.origin}/delete_all_notifications.php`,
        method: 'GET',
        success: function(data) {
            $('.dropdown-item').remove();
        }
    });
}

function createNotiRow(item) {
    return `<button class="dropdown-item" type="button"><div><span><p style="font-weight:500; display:inline">${item.data.subject}</p> 글에 '${item.data.contents}' 댓글 달림</span></div><p id="${item.id}">x</p><p class="board-id" style="display:none;">${item.data.board_id}</p></button>`;
}