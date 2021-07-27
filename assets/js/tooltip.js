$(function () {
    var tooltipTimeoutTimer; // to take away tooltip which have timeout

    function showTooltipRelatedTo(el) {
        $('.tooltip-simple').hide();
        var offset =  el.offset();
        var tooltip =  $('.' + el.attr('tooltip-class'));
        var direction = el.attr('tooltip-direction');
        var align = el.attr('tooltip-align');
        
        if (direction === 'left') {
            tooltip.css('top', offset.top - $(window).scrollTop() + parseInt(el.css('margin-top')) +'px');
            tooltip.css('left', offset.left + parseInt(el.css('margin-left')) + (el.width()+5)+'px');
            // tooltip.fadeIn( 250 );
        }

        if (direction === 'right') {
            tooltip.show();
            tooltip.css('top', offset.top - $(window).scrollTop() + parseInt(el.css('margin-top')) +'px');
            tooltip.css('left', offset.left - tooltip.outerWidth() - 5 +'px');
            tooltip.hide();
            // tooltip.fadeIn( 250 );
            
        }

        if (direction === 'up') {
            tooltip.show();
            tooltip.css('top', offset.top - $(window).scrollTop() - tooltip.outerHeight() - 5 +'px');
            if (align === 'right') {
                tooltip.css('left', offset.left + (el.width() - tooltip.outerWidth()) + 'px');
            } else {
                tooltip.css('left', offset.left + parseInt(el.css('margin-left')) +'px');
            }
            tooltip.hide();
            // tooltip.fadeIn( 250 );
        }

        if (direction === 'down') {
            tooltip.show();
            tooltip.css('top', offset.top + el.height() - $(window).scrollTop() + parseInt(el.css('margin-bottom')) + 5 +'px');
            if (align === 'right') {
                tooltip.css('left', offset.left + (el.width() - tooltip.outerWidth()) + 'px');
            } else {
                tooltip.css('left', offset.left + parseInt(el.css('margin-left')) +'px');
            }
            tooltip.hide();
        }
        tooltip.fadeIn( 250 );
        return;
    }

    function hideTooltipRelatedTo(el) {
        var tooltip =  $('.' + el.attr('tooltip-class'));
            tooltip.fadeOut( 150 );
            clearInterval(tooltipTimeoutTimer);
        return;
    }

    $(document).on('mouseenter', '.tooltip-target', function() {
        $(this).data('timerId', setTimeout(showTooltipRelatedTo, 700, $(this)));
        tooltipTimeoutTimer = setTimeout(hideTooltipRelatedTo, 7000, $(this));
    
    });
    $(document).on('mouseleave', '.tooltip-target:not(.tooltip-on-click)', function() {
        clearInterval($(this).data('timerId'));
        clearInterval(tooltipTimeoutTimer);
        hideTooltipRelatedTo($(this));
        
    });

    // $(document).on('click', '.tooltip-target.tooltip-on-click', function() {
    //     clearInterval($(this).data('timerId'));
    //     clearInterval(tooltipTimeoutTimer);
    //     tooltipTimeoutTimer = setTimeout(hideTooltipRelatedTo, 5000, $(this));
    //     showTooltipAtTheTopOfTheScreen($(this));
        
    // });


    // function showTooltipAtTheTopOfTheScreen(el) {
    //     $('.tooltip-simple').hide();
    //     var tooltip =  $('.' + el.attr('tooltip-on-click-class'));
        
    //     tooltip.css('top', '5px');
    //     tooltip.css('left', '100px');
    //     tooltip.fadeIn( 250 );

    // }


});
