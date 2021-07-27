var markerId = 0; // here stores id of last marker we interact with
var markerIndex = -1; // here stores index of last marker we interact with. index from markers array
var markers = [];
var picsToCreateMarker = [];
var clickedPicId = 0;
var timerCheckGroupOrMarkerPicsLoaded = 0;
var backUpTimerCheckGroupOrMarkerPicsLoaded = 0; // #setInterval bug. setInterval do nothing sometimes apparently every 15th timer
var noMap = false; 

var goldIconObject = {
        iconUrl: '/assets/images/marker/gold.png',
        shadowUrl: '/assets/images/marker/shadow.png',
        iconSize:     [25, 41], 
        shadowSize:   [25, 17], 
        iconAnchor:   [13, 41], 
        shadowAnchor: [2, 19],  
        popupAnchor:  [-3, -35] 
    };    

var goldIconObjectPhase0 = JSON.parse(JSON.stringify(goldIconObject));
    goldIconObjectPhase0.iconUrl = '/assets/images/marker/gold.png';
var goldIconObjectPhase1 = JSON.parse(JSON.stringify(goldIconObject));
    goldIconObjectPhase1.iconUrl = '/assets/images/marker/gold1.png';
var goldIconObjectPhase2 = JSON.parse(JSON.stringify(goldIconObject));
    goldIconObjectPhase2.iconUrl = '/assets/images/marker/gold2.png';
var goldIconObjectPhase3 = JSON.parse(JSON.stringify(goldIconObject));
    goldIconObjectPhase3.iconUrl = '/assets/images/marker/gold3.png';

var goldIconObjectBig = {
        iconUrl: '/assets/images/marker/gold.png',
        shadowUrl: '/assets/images/marker/shadow.png',
        iconSize:     [50, 82], 
        shadowSize:   [50, 34], 
        iconAnchor:   [26, 82], 
        shadowAnchor: [4, 38],  
        popupAnchor:  [-3, -35] 
    };    

var goldIconObjectPhaseBig0 = JSON.parse(JSON.stringify(goldIconObjectBig));
    goldIconObjectPhaseBig0.iconUrl = '/assets/images/marker/gold.png';
var goldIconObjectPhaseBig1 = JSON.parse(JSON.stringify(goldIconObjectBig));
    goldIconObjectPhaseBig1.iconUrl = '/assets/images/marker/gold1.png';
var goldIconObjectPhaseBig2 = JSON.parse(JSON.stringify(goldIconObjectBig));
    goldIconObjectPhaseBig2.iconUrl = '/assets/images/marker/gold2.png';
var goldIconObjectPhaseBig3 = JSON.parse(JSON.stringify(goldIconObjectBig));
    goldIconObjectPhaseBig3.iconUrl = '/assets/images/marker/gold3.png';



var greenIconObject = {
        iconUrl: '/assets/images/marker/green.png',
        shadowUrl: '/assets/images/marker/shadow.png',
        iconSize:     [25, 41], 
        shadowSize:   [25, 17], 
        iconAnchor:   [13, 41], 
        shadowAnchor: [2, 19],  
        popupAnchor:  [-3, -35] 
    };    

var greenIconObjectPhase0 = JSON.parse(JSON.stringify(greenIconObject));
    greenIconObjectPhase0.iconUrl = '/assets/images/marker/green1.png';
var greenIconObjectPhase1 = JSON.parse(JSON.stringify(greenIconObject));
    greenIconObjectPhase1.iconUrl = '/assets/images/marker/green2.png';
var greenIconObjectPhase2 = JSON.parse(JSON.stringify(greenIconObject));
    greenIconObjectPhase2.iconUrl = '/assets/images/marker/green3.png';
var greenIconObjectPhase3 = JSON.parse(JSON.stringify(greenIconObject));
    greenIconObjectPhase3.iconUrl = '/assets/images/marker/green4.png';

var greenIconObjectBig = {
        iconUrl: '/assets/images/marker/green.png',
        shadowUrl: '/assets/images/marker/shadow.png',
        iconSize:     [50, 82], 
        shadowSize:   [50, 34], 
        iconAnchor:   [26, 82], 
        shadowAnchor: [4, 38],  
        popupAnchor:  [-3, -35] 
    };    

var greenIconObjectPhaseBig0 = JSON.parse(JSON.stringify(greenIconObjectBig));
    greenIconObjectPhaseBig0.iconUrl = '/assets/images/marker/green1.png';
var greenIconObjectPhaseBig1 = JSON.parse(JSON.stringify(greenIconObjectBig));
    greenIconObjectPhaseBig1.iconUrl = '/assets/images/marker/green2.png';
var greenIconObjectPhaseBig2 = JSON.parse(JSON.stringify(greenIconObjectBig));
    greenIconObjectPhaseBig2.iconUrl = '/assets/images/marker/green3.png';
var greenIconObjectPhaseBig3 = JSON.parse(JSON.stringify(greenIconObjectBig));
    greenIconObjectPhaseBig3.iconUrl = '/assets/images/marker/green4.png';

var blueIconObject = {
        iconUrl: '/assets/images/marker/blue.png',
        shadowUrl: '/assets/images/marker/shadow.png',
        iconSize:     [25, 41], 
        shadowSize:   [25, 17], 
        iconAnchor:   [13, 41], 
        shadowAnchor: [2, 19],  
        popupAnchor:  [-3, -35] 
    };    

var blueIconObjectBig = {
        iconUrl: '/assets/images/marker/blue.png',
        shadowUrl: '/assets/images/marker/shadow.png',
        iconSize:     [50, 82], 
        shadowSize:   [50, 34], 
        iconAnchor:   [26, 82], 
        shadowAnchor: [4, 38],  
        popupAnchor:  [-3, -35] 
    };    

function getIcon(markerType, markerLifePhase, big = false) {
    if (big) {
        if (markerType === 0) {
            if (markerLifePhase === 0) return L.icon(goldIconObjectPhaseBig0);
            if (markerLifePhase === 1) return L.icon(goldIconObjectPhaseBig1);
            if (markerLifePhase === 2) return L.icon(goldIconObjectPhaseBig2);
            if (markerLifePhase === 3) return L.icon(goldIconObjectPhaseBig3);
        }
        if (markerType === 1) {
            if (markerLifePhase === 0) return L.icon(greenIconObjectPhaseBig0);
            if (markerLifePhase === 1) return L.icon(greenIconObjectPhaseBig1);
            if (markerLifePhase === 2) return L.icon(greenIconObjectPhaseBig2);
            if (markerLifePhase === 3) return L.icon(greenIconObjectPhaseBig3);
        }
        if (markerType === 2) {
            return L.icon(blueIconObjectBig);
        }
    } else {
        if (markerType === 0) {
            if (markerLifePhase === 0) return L.icon(goldIconObjectPhase0);
            if (markerLifePhase === 1) return L.icon(goldIconObjectPhase1);
            if (markerLifePhase === 2) return L.icon(goldIconObjectPhase2);
            if (markerLifePhase === 3) return L.icon(goldIconObjectPhase3);
        }
        if (markerType === 1) {
            if (markerLifePhase === 0) return L.icon(greenIconObjectPhase0);
            if (markerLifePhase === 1) return L.icon(greenIconObjectPhase1);
            if (markerLifePhase === 2) return L.icon(greenIconObjectPhase2);
            if (markerLifePhase === 3) return L.icon(greenIconObjectPhase3);
        }
        if (markerType === 2) {
            return L.icon(blueIconObject);
        }
    }
}



$(function () {
    if ($('#map.no-map').length) {
        noMap = true;
        // console.log('noMap');
    }
    var columnsCount = 0;
    if ($('.colIncoming').length) {
        columnsCount++;
    }
    if ($('.colMarker').length) {
        columnsCount++;
    }

    function setMapAndColumnsSize() {
        var colPicWidth = getCookie('colPicWidth');
        var windowHeight = (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight);
        var mapSpaceWidth = parseInt($('#mapSpace').css('width'));   //(window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth);
        console.log('mapSpaceWidth',mapSpaceWidth);
        var mapSize = Math.floor(windowHeight * 0.97);
        var mainWrapperWidth = colPicWidth * columnsCount + mapSize;
        if (mainWrapperWidth > mapSpaceWidth) {
            mapSize = mapSpaceWidth - colPicWidth * columnsCount;
            mapSize = Math.floor(mapSize * 0.97);
            mainWrapperWidth = colPicWidth * columnsCount + mapSize;
        }

        var mapBorderInPx = parseInt($('#map').css('borderWidth'));

        $('#map').css('width', mapSize - 2*mapBorderInPx);
        $('#map').css('height', mapSize - 2*mapBorderInPx);
        $('.col-preview').css('height', mapSize);
        $('.col-preview').css('width', colPicWidth);
        $('.mainMapWrapper').css('width', mainWrapperWidth);
    }

    setMapAndColumnsSize();

    $( window ).resize(function() {
        setMapAndColumnsSize();
    });


    var lastMapLat = getCookie('lastMapLat') ? getCookie('lastMapLat') : 0;
    var mapLastLng = getCookie('lastMapLng') ? getCookie('lastMapLng') : 0;
    var mapZoom = getCookie('lastMapZoom') ? getCookie('lastMapZoom') : 0;
    var map = L.map('map', {
            minZoom: 4,
            maxZoom: 8,
            center: [lastMapLat,mapLastLng],
            zoom: mapZoom,
            crs: L.CRS.Simple,
            maxBounds: [
                [20, -20],
                [-55, 55]
            ],             
        });
    var url = $('#map').attr('map-url');

    // calculate the edges of the image, in coordinate space
    var southWest = map.unproject([0, 4000], map.getMaxZoom()-1);
    var northEast = map.unproject([4000, 0], map.getMaxZoom()-1);
    var bounds = new L.LatLngBounds(southWest, northEast);
    
    L.imageOverlay(url, bounds).addTo(map);
    var popup = L.popup();    
    map.on('click', onMapClick);


    function onMapClick(e) {
        if (noMap) return;
        console.log('Click at '+e.latlng.toString());
        console.log('picsToCreateMarker');
        console.log(picsToCreateMarker);
		if (picsToCreateMarker.length) {
            var markerType = getCookie('defaultMarkerType'); 
            addMarkerWithPic(e.latlng.lat,e.latlng.lng,markerType);
        }						
    }

    map.on("moveend", function () {
        setCookie('lastMapLat', map.getCenter().lat);
        setCookie('lastMapLng', map.getCenter().lng);
    });

    map.on('zoomend', function() {
        setCookie('lastMapZoom', map.getZoom());
    });

    // function onPopupOpen() {
    //     var tempMarker = this;
    //     markerId = tempMarker.id;
    //     refreshMarkerColumn();
    // }     

    function removeAllMarkers(){
        var markersCount = markers.length;
        for(var i=0; i< markersCount; i++){
	        map.removeLayer(markers[i]);
        }
    }

 


    $(".colMarker").sortable({
        connectWith: ".colMarker",
        handle: ".pic-preview",
        cancel: ".portlet-toggle",
        placeholder: "portlet-placeholder ui-corner-all"
    });

    $(".portlet-toggle").on("click", function () {
        var icon = $(this);
        icon.closest(".portlet").find(".portlet-content").toggle();
    });



    function refreshIncomingColumn() {
        if (!getCookie('usi')) return;

        $.ajax({
            type: 'POST',
            url: '/map/getIncomingColumn',
            data: '',
            success: function (data) {
                var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    var oldHash = $(".col-preview.colIncoming").attr('hash');
                    // console.log('old hash >', oldHash);
                    // console.log('new hash >', data['incomingColumnHash']);
                    if (data['incomingColumnHash'] !== oldHash) {
                        $(".col-preview.colIncoming").html(data['incomingColumnHtml']);
                        $(".col-preview.colIncoming").attr('hash', data['incomingColumnHash'])
                    } else {
                        // console.log('No need to refresh incoming column');
                    }
                }
                // console.log('refreshIncomingColumn');
            }
        });
    }

    function refreshMarkerColumn(showMarkerPicturesBigSize = false, refreshByClick = 0) {
        if (noMap) return;
        if (markerId === 0) {
            var html = (getCookie('doNotShowTooltips') === '1') ? '' : '<a class="column-label"> Marker\'s gallery </a>';
            $(".col-preview.colMarker").html(html);
            return;
        }
        var ajaxId = Math.random().toString(36).substring(7);
        $(".col-preview.colMarker").attr('ajax-allowed-to-act', ajaxId);
        var params = 'markerId=' + markerId + '&ajaxId=' + ajaxId + '&refreshByClick=' + refreshByClick;

        $.ajax({
            type: 'POST',
            url: '/map/showMarker',
            data: params,
            success: function (data) {
                var ajaxId = $(".col-preview.colMarker").attr('ajax-allowed-to-act');
                var data = JSON.parse(data);

                if (data['status'] === 'OK') {
                    var oldHash = $(".col-preview.colMarker").attr('hash');
                    if (data['markerColumnHash'] !== oldHash && data['ajaxId'] === ajaxId ) {
                        $(".col-preview.colMarker").html(data['markerColumnHtmlWithoutTimePanel']);
                        $(".col-preview.colMarker").attr('hash', data['markerColumnHash']);
                    }
                    $(".marker-info>.time-panel").html(data['timePanelHtml']);
                    if (data['showRemainMarkers'] === true) {
                        $('.markers-remain').removeClass('hide');
                        $('.markers-remain').html('Markers '+ data['usedMarkers']+'/'+data['totalMarkers']);
                    } else {
                        $('.markers-remain').addClass('hide');
                    }
                    if (showMarkerPicturesBigSize) {
                        $( ".colMarker .pic-preview" ).first().trigger( "click" );
                    }
                }
                 
            }
        });
    }

    function unselectMarker() {
        markerId = 0;
        $(".col-preview.colMarker").html('');
    }

    $(document).on("click", ".moveToMarker", function (e) {
        if (noMap) return;
        if (markerId) {

            var picsToMove = [];
            if (window.event.ctrlKey) { // if holding ctrl then delete all pics with that group
                var group = $(this).parent('.pic-preview').attr('groupOrMarker');
                $('.pic-preview[groupOrMarker="'+group+'"]').each(function( index ) {
                    picsToMove.push($(this).attr('picId'));
                });
                $('.pic-preview[groupOrMarker="'+group+'"]').appendTo('.col-preview.colMarker');
            } else {
                picsToMove.push($(this).parent('.pic-preview').attr('picId'));
                $(this).parent().parent().appendTo('.col-preview.colMarker');
            }

            $.ajax({
                type: 'POST',
                url: '/map/pic/move/to/marker',
                data: 'picIds=' + JSON.stringify(picsToMove) + '&markerId=' + markerId,
                success: function (data) {
                    if (data === 'OK') {
                        refreshMarkerColumn();
                        reloadMapMarkers();
                        console.log('ALL GOOD');
                    }
                }
            });
        }

        e.preventDefault();
        e.stopPropagation();
    });
    
    /**
     * Moving pic to incoming.
     * Moving to incoming can do only owners(senders) of picture. Read documentation
     */
    $(document).on("click", ".moveToIncoming", function (e) {
        if (noMap) return;
        var picsToMove = [];
        if (window.event.ctrlKey) { // if holding ctrl then delete all pics with that group
            var group = $(this).parent('.pic-preview').attr('groupOrMarker');
            $('.pic-preview[groupOrMarker="'+group+'"]').each(function( index ) {
                picsToMove.push($(this).attr('picId'));
            });
            $('.pic-preview[groupOrMarker="'+group+'"]').appendTo('.col-preview.colIncoming');
        } else {
            picsToMove.push($(this).parent('.pic-preview').attr('picId'));
            $(this).parent().parent().appendTo('.col-preview.colIncoming');
        }

        $.ajax({
            type: 'POST',
            url: '/map/pic/move/to/incoming',
            data: 'picIds=' + JSON.stringify(picsToMove) + '&markerId=' + markerId,
            success: function (data) {
                if (data === 'OK') {
                    refreshIncomingColumn();
                    console.log('ALL GOOD');
                }
            }
        });

        e.preventDefault();
        e.stopPropagation();
    });

    /**
     * Deleting pic
     * 
     */
    $(document).on("click", ".picDelete", function (e) {
        var colIncoming = $(this).parent().parent().parent().hasClass('colIncoming');
        var colMarker = $(this).parent().parent().parent().hasClass('colMarker');

        var picsToDelete = [];
        if (window.event.ctrlKey) { // if holding ctrl then delete all pics with that group
            var group = $(this).parent('.pic-preview').attr('groupOrMarker');
            $('.pic-preview[groupOrMarker="'+group+'"]').each(function( index ) {
                picsToDelete.push($(this).attr('picId'));
            });
            $('.pic-preview[groupOrMarker="'+group+'"]').remove();
        } else {
            picsToDelete.push($(this).parent('.pic-preview').attr('picId'));
            $(this).parent().parent().remove();
        }


        $.ajax({
            type: 'POST',
            url: '/map/delete/pic',
            data: 'picIds=' + JSON.stringify(picsToDelete) + '&markerId=' + markerId,
            success: function (data) {
                console.log(data);
                if (data === 'OK') {
                    if (colIncoming)
                        refreshIncomingColumn();
                    if (colMarker)
                        refreshMarkerColumn();
                    console.log('ALL GOOD');
                }
            }
        });

        e.preventDefault();
        e.stopPropagation();
    });

    /**
     * Show group of pictures in big size. 
     * Group means few pictures with same outline color at incoming or all pics of marker.
     */

    $(document).on("click", ".pic-preview", function (e) {
        var group = $(this).attr('groupOrMarker');
        clickedPicId = $(this).attr('picId');
        console.log('clickedPicId', clickedPicId);
        $('.col-preview, #map').hide();
        var pictureWidth = getCookie('pictureWidth');
            pictureWidth = pictureWidth ? 'style="width:'+pictureWidth+'%"' : '';
        var html = (getCookie('doNotShowTooltips') === '1') ? '<div class="gallery"> ' : '<div class="gallery"><div class="closeGallery" '+pictureWidth+'>Back to Map</div>';

        $('.pic-preview[groupOrMarker="'+group+'"]').each(function( index ) {
            var picId = $(this).attr('picId');
            var picUrl = $(this).attr('picUrl');
            html += '<div class="galleryItem" picId="'+picId+'"> <img src="' + picUrl + '"' + pictureWidth +'> </div>';
        });
        html += '</div>';
        $('.mainMapWrapper').hide();
        $('.mainMapWrapper').append(html);
        timerCheckGroupOrMarkerPicsLoaded = setInterval(checkGroupOrMarkerPicsLoaded, 200);
        backUpTimerCheckGroupOrMarkerPicsLoaded = setTimeout(checkGroupOrMarkerPicsLoaded, 3000); // #setInterval bug. setInterval do nothing sometimes apparently every 15th timer
        console.log('setInterval for timer >', timerCheckGroupOrMarkerPicsLoaded);
        setTimeout(() => { clearInterval(timerCheckGroupOrMarkerPicsLoaded);}, 25000);
    });

    /**
     * Hide group of pictures at big size.
     * Show usuall interface
     */
    $(document).on("click", ".galleryItem, .closeGallery", function (e) {
        $('.gallery').remove();
        $('.col-preview, #map').show();        
    });

    function checkGroupOrMarkerPicsLoaded() {
        console.log('checkGroupOrMarkerPicsLoaded calling');
        var allPicsLoaded = true;
        $('.gallery .galleryItem img').each(function( index ) {
            if (/*!this.complete || */this.naturalHeight === 0) {
                allPicsLoaded = false;
            }
            console.log('height',this.naturalHeight,' complete',this.complete, ' picId ',$(this).parent().attr('picId'));
        });

        if (allPicsLoaded) {
            console.log('clearing interval', timerCheckGroupOrMarkerPicsLoaded);
            clearInterval(timerCheckGroupOrMarkerPicsLoaded);
            clearInterval(backUpTimerCheckGroupOrMarkerPicsLoaded);// #setInterval bug. setInterval do nothing sometimes apparently every 15th timer
            scrollToClickedPicId();
        }

    }

    function scrollToClickedPicId() {
        $('.mainMapWrapper').show();
        // console.log('Scrolling to clickedPicId : ',clickedPicId);
        var sumHeight = 0;
        $('.gallery .galleryItem img').each(function() {
            var picId = $(this).parent().attr('picId');
            // console.log('picId',picId);
            if (parseInt(picId) == parseInt(clickedPicId)) {
                // console.log('Scrolling to sumHeight : ',sumHeight);                
                $(window).scrollTop(sumHeight);
                return;
            } else {
                sumHeight += parseInt($(this).parent().height()) + parseInt($(this).css("margin-top"));
                // console.log('height ',$(this).parent().height() + parseInt($(this).css("margin-top")));
            }
        });
    }




    $(document).on("click", ".picNewMarker", function (e) {
        var group = $(this).parent('.pic-preview').attr('groupOrMarker');
        picsToCreateMarker = [];
        $('.pic-preview[groupOrMarker="'+group+'"]').each(function( index ) {
            picsToCreateMarker.push($(this).attr('picId'));
        });

//        console.log(getCookie('doNotShowTooltips'));

        if (!getCookie('doNotShowTooltips')) {
            $('#map').addClass('border');
            setMapAndColumnsSize();
            $('.map-tooltip').fadeIn(250);

            setTimeout(() => {$('#map').removeClass('border');setMapAndColumnsSize();$('.map-tooltip').fadeOut(150);}, 4000);
        }


        e.preventDefault();
        e.stopPropagation();
    });

    function addMarkerWithPic(lat, lng, markerType) {
        if (noMap) return;
        $.ajax({
            type: 'POST',
            url: '/map/add/markerWithPic',
            data: 'picIds=' + JSON.stringify(picsToCreateMarker) + '&lat=' + lat + '&lng=' + lng + '&type=' + markerType,
            success: function (data) {
                var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    markerId = data['markerId'];
                    var markerRefreshTime = data['markerRefreshTime'];
                    var picsCount = picsToCreateMarker.length;
                    for(var i=0; i< picsCount; i++) {
                        $('.pic-preview[picId="'+picsToCreateMarker[i]+'"]').parent().remove();
                    }
                    refreshMarkerColumn();
                    reloadMapMarkers();
                }
                picsToCreateMarker = [];                
            }
        });

    }
 
    function reloadMapMarkers(removeMarkers = true) {
        if (noMap) return;
        $.ajax({
            type: 'POST',
            url: '/map/getMapMarkers',
            data: '',
            success: function (data) {
                var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    if (data['markersHash'] === $("#map").attr('hash')) return;

                    $("#map").attr('hash', data['markersHash']);
                    if (removeMarkers) removeAllMarkers();
                    markers = [];
                    var markersCount = data['markers'].length;
                    markerIndex = -1;
                    for(var i=0; i < markersCount; i++) {
                        markerType = data['markers'][i]['type'];
                        markerLifePhase = data['markers'][i]['lifePhase'];
                        markers[i] = L.marker([data['markers'][i]['lat'],data['markers'][i]['lng']]).addTo(map) ;
                        if (markerId === parseInt(data['markers'][i]['id'])) {
                            markerIndex = i;
                            markers[i].setIcon(getIcon(markerType, markerLifePhase, big = true));
                        } else {
                            markers[i].setIcon(getIcon(markerType, markerLifePhase));
                        }
                        markers[i].time = data['markers'][i]['refreshTime'];
                        markers[i].type = markerType;
                        markers[i].lifePhase = markerLifePhase;

                        markers[i].id = data['markers'][i]['id'];
                        markers[i].index = i;
                        markers[i].on("click", function(){
                            if (window.event.ctrlKey && window.event.altKey) { 
                                deleteMarker(this.id);
                            } else {
                                // console.log(markerId);
                                // console.log(markerIndex);
                                
                                if (markerIndex >= 0) markers[markerIndex].setIcon(getIcon(markers[markerIndex].type, markers[markerIndex].lifePhase));
                                this.setIcon(getIcon(this.type, this.lifePhase, big = true));
                                markerId = this.id;
                                markerIndex = this.index;
                                refreshMarkerColumn(window.event.ctrlKey, 1);
                            }
                               
                        });                        
                    }
                    
                }
            }
        });

    }

    reloadMapMarkers();

    $(document).on("click", ".marker-control .delete", function (e) {
        if (noMap) return;
        var markerId = $(this).attr('markerId');
        deleteMarker(markerId);
        e.preventDefault();
        e.stopPropagation();
    });

    function deleteMarker(id) {
        if (noMap) return;
        $.ajax({
            type: 'POST',
            url: '/map/delete/marker',
            data: 'markerId=' + id,
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    if (parseInt(id) === markerId) { // the delete marker is the same as the display marker
                        markerId = 0;
                        markerIndex = -1;
                    }
                    reloadMapMarkers();
                    refreshMarkerColumn();
                }
                
            }
        });
    }

    $(document).on("click", ".marker-control .refresh-time", function (e) {
        if (noMap) return;
        var markerId = $(this).attr('markerId');
        $.ajax({
            type: 'POST',
            url: '/map/refresh/marker',
            data: 'markerId=' + markerId,
            success: function (data) {
            var data = JSON.parse(data);
                if (data['status'] === 'OK') {
                    reloadMapMarkers();
                    refreshMarkerColumn();
                }
                
            }
        });
        e.preventDefault();
        e.stopPropagation();
    });


    // =====================================================================================================
    // ======= Choose marker type ======================
    function hideMarkerTypeOptionsRelatedTo(el) {
        var markerOptionsClass = el.attr('marker-option-class');
        $('.' + markerOptionsClass).not('.hide').addClass('hide');
    }

    function showMarkerTypeOptionsRelatedTo(el, direction = 'left') {
        
        var markerOptionsClass = el.attr('marker-option-class');
        // console.log('markerOptionsClass', markerOptionsClass);
        var elements = $('.' + markerOptionsClass).not('[type='+el.attr('type')+']').removeClass('hide');
        // console.log('el', el);
        // console.log('elements', elements);
        var pos =  el.position();
        var offset =  el.offset();
        // console.log('pos', pos);
        // console.log('offset', offset);
        
        if (direction === 'left') {
            var i;
            for (i = 0; i < elements.length; i++) {
                $(elements[i]).css('top', pos.top + parseInt(el.css('margin-top')) +'px');
                $(elements[i]).css('left', pos.left + parseInt(el.css('margin-left')) + (i+1)*($(elements[i]).width()+5)+'px');
            }
        }

        if (direction === 'down') {
            var i;
            for (i = 0; i < elements.length; i++) {
                $(elements[i]).css('top', pos.top + parseInt(el.css('margin-top')) + (i+1)*($(elements[i]).height()+5)+'px');
                $(elements[i]).css('left', pos.left + parseInt(el.css('margin-left')) +'px');
            }
        }

    }

    $(document).on("click", ".default-marker-type-changer", function (e) {
        var el = $(this);
        var tooltip =  $('.' + el.attr('tooltip-class'));
            tooltip.fadeOut( 150 );

        // console.log('el', el);
        var pos =  el.position();
        // console.log('pos', pos);
            if (el.hasClass('opened')) {
                el.removeClass('opened');
                hideMarkerTypeOptionsRelatedTo(el);
                $('#sidepanel').removeClass('marker-type-changing');
            } else {
                el.addClass('opened');
                $('#sidepanel').addClass('marker-type-changing');
                showMarkerTypeOptionsRelatedTo(el);
            }
        e.preventDefault();
        e.stopPropagation();
    });

    $(document).on("click", ".marker-type-changer", function (e) {
        var el = $(this);
            if (el.hasClass('opened')) {
                el.removeClass('opened');
                hideMarkerTypeOptionsRelatedTo(el);
                refreshMarkerColumnTimerId = setInterval(refreshMarkerColumn, refreshFrequently); 
            } else {
                el.addClass('opened');
                showMarkerTypeOptionsRelatedTo(el, 'down');
                clearInterval(refreshMarkerColumnTimerId);
            }
        e.preventDefault();
        e.stopPropagation();
    });

    
    $(document).on("click", ".marker-type-option", function (e) {
        var el = $(this);

        if ($('.default-marker-type-changer').hasClass('opened')) {
            $('.default-marker-type-changer').removeClass('opened');
            $('.default-marker-type-changer').attr('src', el.attr('src'));
            $('.default-marker-type-changer').attr('type', el.attr('type'));
            function logMarkerTypeChanging(markerType) {
                $.ajax({
                    type: 'POST',
                    url: '/user/logMarkerChangeType',
                    data: 'defaultMarkerType=' + markerType,
                    success: function (data) {
                    var data = JSON.parse(data);
                        if (data['status'] === 'OK') {
                        }
                    }
                });
            }

            setCookie('defaultMarkerType', el.attr('type'));
            console.log(el.attr('type'));
            logMarkerTypeChanging(el.attr('type'));

            hideMarkerTypeOptionsRelatedTo(el);
            $('#sidepanel').removeClass('marker-type-changing');
            console.log('ref inc');
            refreshIncomingColumn();
        }
        
        if ($('.marker-type-changer').hasClass('opened')) {
            $('.marker-type-changer').removeClass('opened');
            $('.marker-type-changer').attr('src', el.attr('src'));
            $('.marker-type-changer').attr('type', el.attr('type'));
            hideMarkerTypeOptionsRelatedTo(el);
            refreshMarkerColumnTimerId = setInterval(refreshMarkerColumn, refreshFrequently); 

            $.ajax({
                type: 'POST',
                url: '/map/marker/changeType',
                data: 'markerId=' + markerId + '&type=' + el.attr('type'),
                success: function (data) {
                var data = JSON.parse(data);
                    if (data['status'] === 'OK') {
                        reloadMapMarkers();
                        refreshMarkerColumn();
                    }
                    
                }
            });
        }

        e.preventDefault();
        e.stopPropagation();
    });
    // =====================================================================================================



// ========  if page in focus, then reload it every 2sec, if not then 30 sec ====================
// var baseUrl = "http://www.soundjay.com/button/";
// var audio = ["beep-01a.mp3", "beep-02.mp3", "beep-03.mp3", "beep-04.mp3", "beep-05.mp3", "beep-06.mp3", "beep-07.mp3", "beep-08b.mp3", "beep-09.mp3"];

    var refreshFrequently = 4000;
    var refreshRarely = 40000;

    var refreshIncomingTimerId = setInterval(refreshIncomingColumn, refreshFrequently);
    var refreshMarkerColumnTimerId = setInterval(refreshMarkerColumn, refreshFrequently); 
    var refreshMapMarkersTimerId = setInterval(reloadMapMarkers, refreshFrequently); 

    $(window).blur(function(){
        clearInterval(refreshIncomingTimerId);
        clearInterval(refreshMarkerColumnTimerId);
        clearInterval(refreshMapMarkersTimerId);
        refreshIncomingTimerId = setInterval(refreshIncomingColumn, refreshRarely);
        refreshMarkerColumnTimerId = setInterval(refreshMarkerColumn, refreshRarely); 
        refreshMapMarkersTimerId = setInterval(reloadMapMarkers, refreshRarely); 
    });
    $(window).focus(function(){
        clearInterval(refreshIncomingTimerId);
        clearInterval(refreshMarkerColumnTimerId);
        clearInterval(refreshMapMarkersTimerId);
        refreshIncomingTimerId = setInterval(refreshIncomingColumn, refreshFrequently);
        refreshMarkerColumnTimerId = setInterval(refreshMarkerColumn, refreshFrequently); 
        refreshMapMarkersTimerId = setInterval(reloadMapMarkers, refreshFrequently); 
        refreshIncomingColumn();
        refreshMarkerColumn();
        reloadMapMarkers();
        // new Audio(baseUrl + "beep-08b.mp3").play();
    //your code
    });    
    // =====================================================================================================



});



