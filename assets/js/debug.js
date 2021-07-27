
$(function () {
    $('.control.cookie.delete').click(function() {
        var cookie = $(this).attr('cookie');
        $.ajax({
            type: 'POST',
            url: '/user/cookieDelete',
            data: 'cookie=' + cookie,
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    // alert(data['status']);
                    // alert(data['cookie']);
                    window.location.href = '/user/cookies';
                } else {
                    alert(data['status']);
                }
            }
        });
        
    });

    $('.control.session.delete').click(function() {
        var session = $(this).attr('session');
        $.ajax({
            type: 'POST',
            url: '/user/sessionDelete',
            data: 'session=' + session,
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    window.location.href = '/user/session';
                } else {
                    alert(data['status']);
                }
            }
        });
        
    });
    
});