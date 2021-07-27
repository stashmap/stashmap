function getCookie(name) {
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
}
function setCookie(name, value, days = 365) {
    var d = new Date;
    d.setTime(d.getTime() + 24*60*60*1000*days);
    var domain = "domain=" + (document.domain.match(/[^\.]*\.[^.]*$/)[0]) + ";";
    document.cookie = name + "=" + value + ";path=/;" + domain + "expires=" + d.toGMTString();
}
function deleteCookie(name) { setCookie(name, '', -1); }

$(function () {
    $('.mainWrapper').first().each(function() {
        var windowWidth = (window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth);
        
        if (windowWidth > 1920) {
            var fontSize = (16 * windowWidth / 1920)+'px';
            var wrapperWidth = (700 * windowWidth / 1920)+'px';

            $('html').css('font-size',fontSize);
            $('.mainWrapper').css('width',wrapperWidth);
        }

    });


    $('.page .settings').first().each(function() {
        $('input, select, select').change(function () {
            $(this).addClass('changed');
        });
        
        $('form').on('submit', function() {
            $('input:not(.changed, [type=hidden]), textarea:not(.changed), select:not(.changed)').prop('disabled', true);
        });
    });

    $('.page .settings.get-user-local-time').first().each(function() {
        //Pad given value to the left with "0"
        function AddZero(num) {
            return (num >= 0 && num < 10) ? "0" + num : num + "";
        }
        var today = new Date();
        var date = today.getFullYear()+'-'+AddZero(today.getMonth()+1)+'-'+AddZero(today.getDate());
        var time = AddZero(today.getHours())+':'+AddZero(today.getMinutes())+':'+AddZero(today.getSeconds());
        $.ajax({
            type: 'POST',
            url: '/user/usertime',
            data: 'datetime=' + date + ' '+ time,
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    console.log(23);
                    setCookie('hourDiff', data['hourDiff']);
                }
            }
        });

    });
    
    $('a[link-to]').click(function(e) {
        var href = $(this).attr('href');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/user/following-link',
            data: 'link=' + $(this).attr('link-to'),
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    window.location.href = href;
                }
            }
        });

    });
    
    
});

