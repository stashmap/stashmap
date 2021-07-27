<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link type="text/css" rel="stylesheet" href="/assets/css/rgbaColorPicker.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/tooltip.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="<?=\Components\Config::get('css')['main.css']?>">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="<?=\Components\Config::get('js')['core.js']?>"></script>        
        <script src="/assets/js/debug.js"></script>        
        <script src="<?=\Components\Config::get('js')['tooltip.js']?>"></script>        

        
    </head>
    <?
        $gradientColorTop = \Components\Storage::get('bodyGradientColorTop',\Components\Config::get('backgroundDefaultGradientColorTop'));
        $gradientColorBottom = \Components\Storage::get('bodyGradientColorBottom',\Components\Config::get('backgroundDefaultGradientColorBottom'));
        $backgroundPictureName = \Components\Storage::get('backgroundImage',\Components\Config::get('backgroundDefaultImage'));
        $backgroundPictureFilename = \Components\Config::get('backgroundImages')[$backgroundPictureName];
    ?>
    <body style="background-repeat: repeat;background: linear-gradient( <?=$gradientColorTop?>, <?=$gradientColorBottom?> ), url('<?=$backgroundPictureFilename?>'); background-attachment: fixed;">
        <div class="page">
            <div class="settings">
                <div class="mainWrapper" style="width: auto">
                    <a class=" btn-link" href="/map">Back to Map</a>
                    <hr>
                    <h1>Cookies:</h1>
                    
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Value</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? $tooltipClass = \Components\Storage::get('doNotShowTooltips')?'':'tooltip-target';?>
                    <? foreach($_COOKIE as $key => $value) : ?>
                        <tr>
                            <td>
                                <span>
                                    <?= $key ?>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <?= $value ?>
                                </span>
                            </td>
                            <td>
                                <img 
                                    class="control cookie delete <?=$tooltipClass?>" 
                                    src="/assets/images/control/del.png"
                                    tooltip-class="tooltip-delete" 
                                    tooltip-direction="down" 
                                    tooltip-align="right" 
                                    cookie="<?=$key?>"
                                >
                                <span class="tooltip-simple tooltip-delete">Delete cookie</span>
                            </td>
                        </tr>
                    <?endforeach;?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>