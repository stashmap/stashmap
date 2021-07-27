<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link type="text/css" rel="stylesheet" href="/assets/css/rgbaColorPicker.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="<?=\Components\Config::get('css')['main.css']?>">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="<?=\Components\Config::get('js')['core.js']?>"></script>        
        <script type="text/javascript" src="/assets/js/rgbaColorPicker.js"></script>

        
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
                <div class="mainWrapper">
                    <a class="btn-link" href="<?=\Components\Storage::get('backTo_Link')?>"><?=\Components\Storage::get('backTo_Label')?></a>
                    <hr>
                    <h1>FAQ</h1>

                    <hr>
                    <h4>Marker types</h4>
                    <p>
                        <h5>Small stash marker</h5>
                        <img src="/assets/images/marker/gold.png">
                        <p>Small stashes decay in three days. But if you dig them up and look inside, their lifetime is extended by another 3 days. This marker shows you the time when a stash is decaying, so you can always come and refresh it, or pick up the loot.</p>
                        <p>Depending on age, markers may be:</p>
                        <img src="/assets/images/marker/gold.png">
                        <img src="/assets/images/marker/gold1.png">
                        <img src="/assets/images/marker/gold2.png">
                        <img src="/assets/images/marker/gold3.png">
                    </p>
                    <hr>
                    <p>
                        <h5>Enemy base marker</h5>
                        <img src="/assets/images/marker/green1.png">
                        <p>This marker is used to mark enemy buildings.</p>
                        <p>Depending on age, markers may be:</p>
                        <img src="/assets/images/marker/green1.png">
                        <img src="/assets/images/marker/green2.png">
                        <img src="/assets/images/marker/green3.png">
                        <img src="/assets/images/marker/green4.png">
                    </p>
                    <hr>
                    <p>
                        <h5>Decaying base marker</h5>
                        <img src="/assets/images/marker/decay.png">
                        <p>You have found the decaying base. Create a decaying base marker. Specify the tier and construction and marker will show after how long the construction will destroy.</p>
                        <p><b><i>**In progress**</i></b></p>
                    </p>
                    <hr>
                    <p>
                        <h5>Simple markers</h5>
                        <img src="/assets/images/marker/gray.png">
                        <img src="/assets/images/marker/blue.png">
                        <img src="/assets/images/marker/magenta.png">
                        <img src="/assets/images/marker/red.png">
                        <p>Just markers to ... mark something.</p>
                    </p>

                    <hr>
                    <h4>How to delete all screenshots of one group/marker</h4>
                    <p> While holding Ctrl click on "delete" button</p>
                    <hr>
                    <h4>How to move all screenshots of one group to marker</h4>
                    <p> While holding Ctrl click on "move to marker" button</p>
                    <hr>
                    
                    <h4>To see large screenshots</h4>
                    <p>Hold down the Ctrl key and click on the marker to see large images at once</p>
                    <hr>
                    <h4>To delete marker</h4>
                    <p>Hold down the Ctrl and ALt key and click on the marker to delete marker</p>
                    <hr>

                    <h4>How to add server IP to StashPic</h4>
                    <p>
                        <ul>
                            <li>Go to <a href="https://www.battlemetrics.com/servers/rust">battle metrics</a></li>
                            <li>Search your server</li>
                            <li>Look for the item "Address"</li>
                            <li>Copy IP-address (like 51.81.48.3:28070)</li>
                            <li>Go to StashPic, tab "Rust"</li>
                            <li>Paste address into field</li>
                        </ul>
                    </p>
                    
                </div>
            </div>
        </div>
    </body>
</html>