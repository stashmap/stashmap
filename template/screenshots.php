<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">        
        <!-- <link rel="stylesheet" href="/assets/css/leaflet.css"> -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <link rel="stylesheet" href="<?=\Components\Config::get('css')['map.css']?>">

        <link href='https://fonts.googleapis.com/css?family=Assistant' rel='stylesheet'>

        <link rel="stylesheet" href="/assets/css/tooltip.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- <script src="/assets/js/leaflet.js"></script>        -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script src="<?=\Components\Config::get('js')['core.js']?>"></script>        
        <script src="<?=\Components\Config::get('js')['map.js']?>"></script>        
        <script src="<?=\Components\Config::get('js')['tooltip.js']?>"></script>
    </head>
    <? $tooltipClass = \Components\Storage::get('doNotShowTooltips')?'':'tooltip-target';?>
    <?
        $gradientColorTop = \Components\Storage::get('bodyGradientColorTop',\Components\Config::get('backgroundDefaultGradientColorTop'));
        $gradientColorBottom = \Components\Storage::get('bodyGradientColorBottom',\Components\Config::get('backgroundDefaultGradientColorBottom'));
        $backgroundPictureName = \Components\Storage::get('backgroundImage',\Components\Config::get('backgroundDefaultImage'));
        $backgroundPictureFilename = \Components\Config::get('backgroundImages')[$backgroundPictureName];
    ?>
    <body style="background-repeat: repeat;background: linear-gradient( <?=$gradientColorTop?>, <?=$gradientColorBottom?> ), url('<?=$backgroundPictureFilename?>'); background-attachment: fixed;">
        <?
            $this->view('partial/sidepanel',[
                'tooltipClass' => $tooltipClass,
                'usi' => $usi,
            ]);
        ?>
        <div id="mapSpace">

            <div class="mainMapWrapper">
                <? if ($usi): ?>
                <div class="col-preview colIncoming screenshots" hash="">
                    <? $this->view('partial/incomingColumn',['pics'=>$pics]); ?>                
                </div>
                <? else: ?>
                <a href="settings"><h2>You need to set Application Unique Sender Id(USI) at settings</h2></a>
                <? endif; ?>
                <? $mapUrl = $this->map ? '/'.\Components\Config::get('folders')['maps'] . '/' . $this->map->map_filename : \Components\Config::get('folders')['maps'] . '/' . \Components\Config::get('no_map_no_registration_filename') ?>
                <div id="map" class="<?= $this->map ? '' : 'no-map' ?>" map-url="<?=$mapUrl?>" hash="">
                </div>
            </div>
        </div>
    </body>
</html>