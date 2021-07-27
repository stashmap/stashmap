$(window).on('load', function() {
    var sharingToolbox = {
        element: $('.social-buttons'),
        height: 40,
        windowOffset: 0,
        getWindowOffset: function () { this.windowOffset = this.element.offset(); }, 
        isFixed: function() { return this.element.hasClass('mobile'); },
        init: function() {
            var me = this;
            if (me.element.length == 0) return;
            $(window).scroll(function () {
                me.getWindowOffset();
                if ($(document).scrollTop()-me.height > me.windowOffset.top) {
                    if (!me.isFixed()) me.element.addClass('mobile');
                } else {
                    if (me.isFixed()) me.element.removeClass('mobile');
                }
            });
        }
    } 
    sharingToolbox.init();
    
    function ga_send(action,socialMedia) {
        if (window.ga) ga('send', {                        
            'hitType': 'event', 
            'eventCategory': 'social',
            'eventAction': action,
            'eventLabel': socialMedia
        });                
    }
     /* social tracking */
    if (document.referrer){                    
        function url(url){                    
            return url.match(/:\/\/(.[^/]+)/)[1];
        }
        if(url(document.referrer) == 't.co') {  
            ga_send('click','twitter');
        }

        if(url(document.referrer) == 'www.facebook.com') {
            ga_send('click','facebook');
        }
    }
    /* social service */
    $('.social-buttons').on('click','.social-btn', function(){
        
        function popupWindow(url, width, height) {
          var left = (screen.width/2)-(width/2);
          var top = (screen.height/2)-(height/2);
          return window.open(url, "displayWindow", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+width+', height='+height+', top='+top+', left='+left);
        }
        
        var $this = $(this);  
        
        switch (true) { 
            case ($this.hasClass('share-whatsapp')):
                var isMobile = window.matchMedia("only screen and (max-width: 767px)");
                if (isMobile.matches) {
                    $(this).attr('href',"whatsapp://send?text="+document.title+" "+encodeURIComponent(location.href)); 
                } else {
                    $(this).attr('href',"https://web.whatsapp.com/send?text="+document.title+" "+encodeURIComponent(location.href)).attr("target", "_blank"); 
                }
                ga_send('share','whatsapp');
                break; 
            case ($this.hasClass('share-facebook')):                 
                popupWindow("http://www.facebook.com/sharer.php?u="+encodeURIComponent(location.href), 600, 300);
                ga_send('share','facebook');                
                break; 
            case ($this.hasClass('share-twitter')): 
                // popupWindow("http://twitter.com/share?url="+encodeURIComponent(location.href), 600, 445);
                popupWindow("http://twitter.com/share?text="+encodeURIComponent(document.title)+"&url="+encodeURIComponent(location.href), 600, 445);                
                ga_send('share','twitter');
                break; 
            case ($this.hasClass('share-pinterest')): 
                var element_script = document.createElement('script'); 
                element_script.setAttribute('type','text/javascript'); 
                element_script.setAttribute('charset','UTF-8'); 
                element_script.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999); 
                document.body.appendChild(element_script); 
                ga_send('share','pinterest');
                break; 
            case ($this.hasClass('share-tumblr')): 
                popupWindow("http://tumblr.com/widgets/share/tool?canonicalUrl="+encodeURIComponent(location.href), 600, 450); 
                ga_send('share','tumblr');
                break; 
        }        
    });
});