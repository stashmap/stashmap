<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="<?=\Components\Config::get('css')['main.css']?>">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="<?=\Components\Config::get('js')['core.js']?>"></script>        
        <script src="/assets/js/speed-dial.js"></script>        
    </head>
    <?
        $gradientColorTop = \Components\Storage::get('bodyGradientColorTop',\Components\Config::get('backgroundDefaultGradientColorTop'));
        $gradientColorBottom = \Components\Storage::get('bodyGradientColorBottom',\Components\Config::get('backgroundDefaultGradientColorBottom'));
        $backgroundPictureName = \Components\Storage::get('backgroundImage',\Components\Config::get('backgroundDefaultImage'));
        $backgroundPictureFilename = \Components\Config::get('backgroundImages')[$backgroundPictureName];
    ?>
    <body style="background-repeat: repeat;background: linear-gradient( <?=$gradientColorTop?>, <?=$gradientColorBottom?> ), url('<?=$backgroundPictureFilename?>'); background-attachment: fixed;">
        <div class="speed-dial-container">
            <a href="https://www.google.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/google.png">
                    </div>
                </div>
            </a>
            <a href="https://www.youtube.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/youtube.png">
                    </div>
                </div>
            </a>
            <a href="/">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/stashMap.png">
                    </div>
                </div>
            </a>
            <a href="https://rustlabs.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rustLabs.png">
                    </div>
                </div>
            </a>
            <a href="https://www.battlemetrics.com/servers/rust">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/battleMetrics.png">
                    </div>
                </div>
            </a>
            <a href="https://rustmaps.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rustMaps.png">
                    </div>
                </div>
            </a>
            <a href="http://playrust.io">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/playrust.png">
                    </div>
                </div>
            </a>
            <a href="https://just-wiped.net">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/justWiped.png">
                    </div>
                </div>
            </a>
            <a href="https://www.rustrician.io">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rustrician.png">
                    </div>
                </div>
            </a>
            <a href="https://pr0xs.github.io/Rust-Genetics-Lab/">
                <div>
                    <div>
                        <h3><b>Rust Genetics Lab</b></h3>
                    </div>
                </div>
            </a>
            <a href="http://www.rustangelo.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rustangelo.png">
                    </div>
                </div>
            </a>
            <a href="https://rust.facepunch.com/blog/">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rust.png">
                    </div>
                </div>
            </a>
            <a href="https://www.corrosionhour.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/corrosionHour.png">
                    </div>
                </div>
            </a>
            <a href="https://www.rustafied.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rustafied.png">
                    </div>
                </div>
            </a>
            <a href="https://rustypot.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rustyPot.png">
                    </div>
                </div>
            </a>
            <a href="https://rustchance.com">
                <div>
                    <div>
                        <img src="/assets/images/speed-dial/rustChance.png">
                    </div>
                </div>
            </a>

            <? $userTilesSet = isset($_COOKIE['userTiles']) ? json_decode($_COOKIE['userTiles']) : null ; ?>
            <? If ($userTilesSet) :?>

            <? foreach($userTilesSet->tiles as $key => $tile):?>
            <a href="<?=str_replace('{$emicolon}',';',$tile->siteUrl)?>">
                <div>
                    <div class="userTile">
                        <h3><?=str_replace('{$emicolon}',';',$tile->siteName) ?></h3>
                        <img class="deleteTile" index="<?=$key?>" src="/assets/images/speed-dial/deleteTile.png">
                    </div>
                </div>
            </a>
            <? endforeach;?>
            <? endif;?>

            <a>
                <div data-toggle="modal" data-target="#exampleModalCenter">
                    <div>
                        <img src="/assets/images/speed-dial/plus.png">
                    </div>
                </div>
            </a>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Website adding</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="siteName" class="form-control" placeholder="Enter website name" value="">
                </div>

                <div class="form-group">
                    <input type="text" id="siteUrl" class="form-control" placeholder="Enter website url" value="">
                </div>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary addTile" data-dismiss="modal">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            </div>
        </div>
        </div>

    </body>
</html>