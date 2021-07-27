<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">


        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">        
        <link rel="stylesheet" href="<?=\Components\Config::get('css')['map-create.css']?>">
        <link rel="stylesheet" href="/assets/css/tooltip.css">

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 
        <script src="<?=\Components\Config::get('js')['core.js']?>"></script>        
        <script src="<?=\Components\Config::get('js')['map-create.js']?>"></script>        
        <script src="<?=\Components\Config::get('js')['tooltip.js']?>"></script>
    </head>
    <? $tooltipClass = \Components\Storage::get('doNotShowTooltips')?'':'tooltip-target';?>
    <?
        $gradientColorTop = \Components\Storage::get('bodyGradientColorTop',\Components\Config::get('backgroundDefaultGradientColorTop'));
        $gradientColorBottom = \Components\Storage::get('bodyGradientColorBottom',\Components\Config::get('backgroundDefaultGradientColorBottom'));
        $backgroundPictureName = \Components\Storage::get('backgroundImage',\Components\Config::get('backgroundDefaultImage'));
        $backgroundPictureFilename = \Components\Config::get('backgroundImages')[$backgroundPictureName];
    ?>
    <body map-parts-hash="<?= $mapPartsHash ?>" style="background-repeat: repeat;background: linear-gradient( <?=$gradientColorTop?>, <?=$gradientColorBottom?> ), url('<?=$backgroundPictureFilename?>'); background-attachment: fixed;">
    <? if(!\Components\Storage::get('usi')): ?>
        <div class="mapEditorWrapper">
            <div class="map-parts-viewport">
                <h2> Sorry, map creation is only possible using the app </h2>
            </div>
        </div>
    <? elseif(!$pics):?>
        <div class="mapEditorWrapper">
            <div class="map-parts-viewport">
                <h2> take a screenshot of the top and bottom of the in-game map </h2>
            </div>
        </div>
    <? else:?>
        <div class="mapEditorWrapper">
            <div class="map-parts-viewport" >
                <div class="map-parts-top" preview=".top" style="width: <?=$pics[1]->width.'px' ?>; height: <?=$pics[1]->height.'px' ?>;top: <?=$pics[1]->top ?>;left: <?=$pics[1]->left ?>; background-image: url('<?= '/'.\Components\Config::get('folders')['pic_uploads'].'/'.$pics[1]->url ?>')">
                </div>
                <div class="map-parts-bottom" preview=".bottom" style="width: <?=$pics[0]->width.'px' ?>; height: <?=$pics[0]->height.'px' ?>;top: <?=$pics[0]->top ?>;left: <?=$pics[0]->left ?>; background-image: url('<?= '/'.\Components\Config::get('folders')['pic_uploads'].'/'.$pics[0]->url ?>')">
                </div>
                <div class="bounds-left-upper-corner-control">
                </div>
                <div class="bounds-right-lower-corner-control">
                </div>
                <div class="bounds-left">
                </div>
                <div class="bounds-top">
                </div>
                <div class="bounds-right">
                </div>
                <div class="bounds-bottom">
                </div>
            </div>
            <div class="col-preview map-layers">
                <? $this->view('map/mapPartColumn',['pics'=>$pics]); ?>                
            </div>
        </div>
    <? endif; ?>
    
        <span class="tooltip-simple tooltip-move-down">Move down one pixel</span>
        <span class="tooltip-simple tooltip-move-up">Move up one pixel</span>
        <span class="tooltip-simple tooltip-move-left">Move left one pixel</span>
        <span class="tooltip-simple tooltip-move-right">Move right one pixel</span>

    </body>
</html>
