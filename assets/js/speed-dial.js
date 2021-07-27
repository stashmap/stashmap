$(function () {
    $(".addTile").on("click", function () {
        var userTilesStr = getCookie('userTiles');
        var userTiles = userTilesStr ? JSON.parse(userTilesStr) : JSON.parse('{"tiles":[]}');
        if (!$('#siteUrl').val()) return;
        if (!$('#siteName').val()) return;
        var siteName = $('#siteName').val();
        var siteUrl = $('#siteUrl').val();
        siteName = siteName.replace(/;/g, "{$emicolon}");
        siteUrl = siteUrl.replace(/;/g, "{$emicolon}");
        siteUrl = siteUrl.match(/http/i) ? siteUrl : "http://"+siteUrl; 
        userTiles['tiles'].push({"siteName":siteName, "siteUrl": siteUrl});
        // console.log(userTiles);
        userTilesStr = JSON.stringify(userTiles);
        // console.log(userTilesStr);
        setCookie('userTiles',userTilesStr);
        location.reload();
    });

    $(".deleteTile").on("click", function (e) {
        var index = $(this).attr("index");
        var userTilesStr = getCookie('userTiles');
        var userTiles = userTilesStr ? JSON.parse(userTilesStr) : JSON.parse('{"tiles":[]}');
        userTiles['tiles'].splice(index,1);
        userTilesStr = JSON.stringify(userTiles);
        console.log(userTilesStr);
        setCookie('userTiles',userTilesStr);
        location.reload();
        return false;
        e.preventDefault;
    });
});