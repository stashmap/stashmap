$(function () {

    function getOffset(selector) {
        return {top :parseInt( $(selector).css('top')), left: parseInt( $(selector).css('left'))};
    }

    function setOffset(selector, offset) {
        $(selector).css('top', offset.top+'px');
        $(selector).css('left', offset.left+'px');
    }

    var colPreviewWidth = parseInt($('.map-layers').css('width'));
     
    var windowHeight = (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight);
    var windowWidth = (window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth);

    var mainWrapperWidth = Math.floor(windowWidth * 0.97);
    var mapViewportHeight = Math.floor(windowHeight * 0.97);
    var mapViewportWidth = mainWrapperWidth - colPreviewWidth;

    $('.map-parts-viewport').css('width', mapViewportWidth);
    $('.map-parts-viewport').css('height', mapViewportHeight);

    $('.mapEditorWrapper').css('width', mainWrapperWidth);
    $('.col-preview').css('height', Math.floor(windowHeight * 0.97));
    $('.col-preview').css('width', colPreviewWidth);

    //Centering map parts control to parent
    var mapLayerPreviewHeight = parseInt($('.pic-preview').css('height')) + parseInt($('.pic-preview').css('padding-top')) + parseInt($('.pic-preview').css('padding-bottom'));
    var mapLayerPreviewImgHeight = parseInt($('.pic-preview').css('height'));

    console.log('after load clicks directly on map control do nothing');
    console.log('need make a square bounds');
    console.log('do bounds when bounds movement');
    console.log(mapLayerPreviewImgHeight);

    var tableWidth = parseInt($('.map-layers-control').css('width'));
    console.log('tableWidth',tableWidth);
    var imgPreviewColumnWidth = parseInt($('.control-element').css('width'));
    $('.map-layers-control').css('left', Math.floor((imgPreviewColumnWidth - tableWidth) / 2)+'px');

    var isDown = false;
    var offsetBeforeMoving;
    var offsetBeforeMovingBoundsRightLowerCornerControl;
    var offsetBeforeMovingBoundsLeftUpperCornerControl;

    var mouseDownX;
    var mouseDownY;
    var selectedMapLayer;

    $(document).on("click", ".pic-preview", function (e) {
        // $('.pic-preview').css('background','none');
        // $(this).css('background','#568cc1');
        selectedMapLayer = $(this).attr('editorMapSelector');
        if (selectedMapLayer === '.map-parts-top' || selectedMapLayer === '.map-parts-bottom') {
            $('.map-parts-bottom').css('opacity',0.6);
        } else {
            $('.map-parts-bottom').css('opacity',1);
        }
    });

    $(document).on("click", ".control-to-move-one-px-up", function (e) {
        var offset = getOffset(selectedMapLayer);
        offset.top = offset.top - 1;
        setOffset(selectedMapLayer, offset);
    });

    $(document).on("click", ".control-to-move-one-px-down", function (e) {
        var offset = getOffset(selectedMapLayer);
        offset.top = offset.top + 1;
        setOffset(selectedMapLayer, offset);
    });

    $(document).on("click", ".control-to-move-one-px-left", function (e) {
        var offset = getOffset(selectedMapLayer);
        offset.left = offset.left - 1;
        setOffset(selectedMapLayer, offset);
    });

    $(document).on("click", ".control-to-move-one-px-right", function (e) {
        var offset = getOffset(selectedMapLayer);
        offset.left = offset.left + 1;
        setOffset(selectedMapLayer, offset);
    });

    $('.bounds-left-upper-corner-control').css('top','50px');
    $('.bounds-left-upper-corner-control').css('left','50px');
    var scrollWidthMapPartsViewport = $('.map-parts-viewport').prop('scrollWidth');
    var scrollHeightMapPartsViewport = $('.map-parts-viewport').prop('scrollHeight');
    $('.bounds-right-lower-corner-control').css('top', (scrollHeightMapPartsViewport-50) +'px');
    $('.bounds-right-lower-corner-control').css('left', (scrollWidthMapPartsViewport-50) +'px');

    function setBoundsSize() {
        var topLeftControlTop = parseInt( $('.bounds-left-upper-corner-control').css('top'));
        var topLeftControlLeft = parseInt( $('.bounds-left-upper-corner-control').css('left'));
        var bottomRightControlTop = parseInt( $('.bounds-right-lower-corner-control').css('top'));
        var bottomRightControlLeft = parseInt( $('.bounds-right-lower-corner-control').css('left'));

        var leftBoundWidth = topLeftControlLeft;
        var rightBoundWidth = scrollWidthMapPartsViewport - bottomRightControlLeft;
        var topBoundWidth = scrollWidthMapPartsViewport - leftBoundWidth - rightBoundWidth;

        $('.bounds-left').css('top','0px');
        $('.bounds-left').css('left','0px');
        $('.bounds-left').width(leftBoundWidth);
        $('.bounds-left').height(scrollHeightMapPartsViewport);

        $('.bounds-top').css('top','0px');
        $('.bounds-top').css('left',topLeftControlLeft+'px');
        $('.bounds-top').height(topLeftControlTop);
        $('.bounds-top').width(topBoundWidth);

        $('.bounds-right').css('top','0px');
        $('.bounds-right').css('left',(leftBoundWidth + topBoundWidth)+'px');
        $('.bounds-right').height(scrollHeightMapPartsViewport);
        $('.bounds-right').width(rightBoundWidth);
        
        $('.bounds-bottom').css('top',bottomRightControlTop+'px');
        $('.bounds-bottom').css('left',topLeftControlLeft+'px');
        $('.bounds-bottom').height(scrollHeightMapPartsViewport - bottomRightControlTop);
        $('.bounds-bottom').width(topBoundWidth);
        
    }



    setBoundsSize();

    $(document).on("mousedown", ".map-parts-top, .map-parts-bottom, .bounds-left-upper-corner-control, .bounds-right-lower-corner-control", function (e) {
        isDown = true;
        selectedMapLayer = '.'+$(this).attr('class');
        offsetBeforeMoving = getOffset(selectedMapLayer);
        if (selectedMapLayer === '.bounds-left-upper-corner-control') {
            offsetBeforeMovingBoundsRightLowerCornerControl = getOffset('.bounds-right-lower-corner-control');
            $('.map-parts-bottom').css('opacity',1);

        }
        if (selectedMapLayer === '.bounds-right-lower-corner-control') {
            offsetBeforeMovingBoundsLeftUpperCornerControl = getOffset('.bounds-left-upper-corner-control');
            offsetBeforeMovingBoundsRightLowerCornerControl = getOffset('.bounds-right-lower-corner-control');
            $('.map-parts-bottom').css('opacity',1);
        }

        mouseDownX = e.clientX;
        mouseDownY = e.clientY;
        if (selectedMapLayer === '.map-parts-top' || selectedMapLayer === '.map-parts-bottom') {
            $('.map-parts-bottom').css('opacity',0.6);
        }
        

    });

    $(document).on("mouseup", function (e) {
        isDown = false;
    });
    
    $(document).on("mousemove", function (e) {
        if (isDown) {
            var deltaX = e.clientX - mouseDownX;
            var deltaY = e.clientY - mouseDownY;

            setOffset(selectedMapLayer,{top:offsetBeforeMoving.top+deltaY, left: offsetBeforeMoving.left+deltaX});
            
            if (selectedMapLayer === '.bounds-right-lower-corner-control') {
                var distTop = offsetBeforeMoving.top+deltaY - offsetBeforeMovingBoundsLeftUpperCornerControl.top;
                var distLeft = offsetBeforeMoving.left+deltaX - offsetBeforeMovingBoundsLeftUpperCornerControl.left;
                console.log(distLeft, distTop);
                if ((distTop) < (distLeft) ) {
                    setOffset(selectedMapLayer, {top:offsetBeforeMovingBoundsLeftUpperCornerControl.top+distTop, left: offsetBeforeMovingBoundsLeftUpperCornerControl.left+distTop});
                } else {
                    setOffset(selectedMapLayer, {top:offsetBeforeMovingBoundsLeftUpperCornerControl.top+distLeft, left: offsetBeforeMovingBoundsLeftUpperCornerControl.left+distLeft});
                }
            }

            if (selectedMapLayer === '.bounds-left-upper-corner-control') {
                setOffset('.bounds-right-lower-corner-control', {top:offsetBeforeMovingBoundsRightLowerCornerControl.top+deltaY, left: offsetBeforeMovingBoundsRightLowerCornerControl.left+deltaX});
            }

            if (selectedMapLayer === '.map-parts-top' || selectedMapLayer === '.map-parts-bottom') {
                scrollWidthMapPartsViewport = $('.map-parts-viewport').prop('scrollWidth');
                scrollHeightMapPartsViewport = $('.map-parts-viewport').prop('scrollHeight');
                setBoundsSize();
            }

            if (selectedMapLayer === '.bounds-left-upper-corner-control' || selectedMapLayer === '.bounds-right-lower-corner-control') {
                setBoundsSize();
            }
        }
    });

    $('.create-map').click(function () {

        var offset = getOffset('.map-parts-top');
        var mapPartsTop_Top = offset.top;
        var mapPartsTop_Left = offset.left;
        offset = getOffset('.map-parts-bottom');
        var mapPartsBottom_Top = offset.top;
        var mapPartsBottom_Left = offset.left;
        offset = getOffset('.bounds-left-upper-corner-control');
        var boundsTopLeft_Top = offset.top;
        var boundsTopLeft_Left = offset.left;
        offset = getOffset('.bounds-right-lower-corner-control');
        var boundsBottomRight_Top = offset.top;
        var boundsBottomRight_Left = offset.left;

        var name = $('#name').val();
        var defaultMap = $('#defaultMap').prop('checked') ? 1 : 0;

        $.ajax({
            type: 'POST',
            url: '/clan/mapCreateImage',
            data: 'name=' + name + '&' + 'defaultMap=' + defaultMap + '&' + 'mapPartsTop_Top=' + mapPartsTop_Top + '&' + 'mapPartsTop_Left=' + mapPartsTop_Left + '&' + 'mapPartsBottom_Top=' + mapPartsBottom_Top + '&' + 'mapPartsBottom_Left=' + mapPartsBottom_Left + '&' + 'boundsTopLeft_Top=' +            boundsTopLeft_Top + '&'+'boundsTopLeft_Left=' + boundsTopLeft_Left + '&' + 'boundsBottomRight_Top=' + boundsBottomRight_Top + '&' + 'boundsBottomRight_Left=' + boundsBottomRight_Left ,
            success: function (data) {
                window.location.href = '/';
            }
        });
    });

    setInterval(function(){
    $.ajax({
        type: 'POST',
        url: '/clan/getMapPartsHash',
        success: function (data) {
            if (data !== $('body').attr('map-parts-hash')) {
                location.reload();
            } else {
                console.log('map parts same. no need to reload page');
            }
            
        }
    });
        

    }, 8000);

    //Pad given value to the left with "0"
    function AddZero(num) {
        return (num >= 0 && num < 10) ? "0" + num : num + "";
    }
    var today = new Date();
    var date = AddZero(today.getDate())+'-'+AddZero(today.getMonth()+1)+'-'+today.getFullYear();
    var time = AddZero(today.getHours())+':'+AddZero(today.getMinutes())+':'+AddZero(today.getSeconds());
    $('#name').val('Map ' + date + ' '+ time);

});

