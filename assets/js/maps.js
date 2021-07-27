$(function () {

    $(".delete").on("click", function () {
        var tr = $(this).parent().parent();

        $.ajax({
            type: 'POST',
            url: '/clan/delete/map',
            data: 'mapId=' + tr.attr('mapId'),
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    if ( $('tbody tr').length === 1) {
                        $('table').hide();
                    } else {
                        tr.hide();
                    }
                }
            }
        });
    });


    $("input.mapname").on("change paste keyup", function() {
        var el = $(this).parent().find('button').addClass('changed');
        el.removeClass('btn-light');
        el.addClass('btn-info');
        el.html('Save');
    });


    $(".btn.save-button").on("click", function () {
        var el = $(this);
        var mapId = el.parent().parent().parent().parent().attr('mapId');
        var newMapName = el.parent().siblings('input').val();
        
        $.ajax({
            type: 'POST',
            url: '/clan/rename/map',
            data: 'mapId=' + mapId + '&newMapName=' + newMapName,
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    el.removeClass('btn-info');
                    el.addClass('btn-light');
                    el.html('Saved');
                }
            }
        });
    });

    $(".makeDefault").on("click", function () {
        var el = $(this);
        var mapId = $(this).parent().parent().attr('mapId');
        
        $.ajax({
            type: 'POST',
            url: '/clan/makeDefault/map',
            data: 'mapId=' + mapId,
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    $('.makeDefault').not(el).attr('src','/assets/images/control/uncheck.png');
                    el.attr('src','/assets/images/control/check.png');
                }
            }
        });
    });

    $('.page .settings.create-map-from-file').first().each(function() {
        //Pad given value to the left with "0"
        function AddZero(num) {
            return (num >= 0 && num < 10) ? "0" + num : num + "";
        }
        var today = new Date();
        var date = AddZero(today.getDate())+'-'+AddZero(today.getMonth()+1)+'-'+today.getFullYear();
        var time = AddZero(today.getHours())+':'+AddZero(today.getMinutes())+':'+AddZero(today.getSeconds());
        // console.log(date + ' '+ time);
        $('#name').val('Map ' + date + ' '+ time);

    });



});