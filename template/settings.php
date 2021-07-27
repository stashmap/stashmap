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
                    <h1>Settings</h1>

                    <form method='post'>
                        <div class="form-group">
                            <label for="usi">Application Unique Sender Id(USI):</label>
                            <input type="text" id="usi" name="usi" class="form-control" placeholder="Enter unique sender id of application" value="<?=$usi; ?>">
                        </div>
                        <?if ($this->isLoggedIn):?>
                        <div class="form-group">
                            <label for="mapId">Map to play on:</label>
                            <select class="form-control" name="mapId" id="mapId">
                                <option <?= \Components\Storage::get('mapToPlayOn' === \Components\Config::get('default_clan_map')) ? 'selected' : '' ?>
                                    <?='value="'.\Components\Config::get('default_clan_map').'"' ?>>Default clan map</option>
                                <? foreach( $maps as $map ): ?>
                                    <option <?= $map->id === (int)\Components\Storage::get('mapToPlayOn') ? 'selected' : '' ?>  <?='value="'.$map->id.'"' ?>><?=$map->name; ?></option>
                                <? endforeach;?>
                            </select>
                        </div>                        
                        <?endif;?>

                        <h4>Background</h4>
                        <? foreach( \Components\Config::get('backgroundImages') as $name => $file): ?>
                            <div class="hide background-image-files" name="<?= $name?>" file="<?= $file ?>"></div>
                        <? endforeach;?>

                        <div class="form-group">
                            <label for="backgroundImage">Image:</label>
                            <select class="form-control" name="backgroundImage" id="backgroundImage">
                                <? foreach( \Components\Config::get('backgroundImages') as $key => $whatever): ?>
                                    <option <?= $key === \Components\Storage::get('backgroundImage', \Components\Config::get('backgroundDefaultImage')) ? 'selected' : '' ?>  <?='value="'.$key.'"' ?>><?=$key; ?></option>
                                <? endforeach;?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bodyGradientColorTop">Background color top:</label>
                            <input type="text" id="bodyGradientColorTop" name="bodyGradientColorTop" class="form-control color" value="<?=\Components\Storage::get('bodyGradientColorTop',\Components\Config::get('backgroundDefaultGradientColorTop'))?>">
                        </div>

                        <div class="form-group">
                            <label for="bodyGradientColorBottom">Background color bottom:</label>
                            <input type="text" id="bodyGradientColorBottom" name="bodyGradientColorBottom" class="form-control color" value="<?=\Components\Storage::get('bodyGradientColorBottom',\Components\Config::get('backgroundDefaultGradientColorBottom'))?>">
                        </div>

                        <hr>
                        <h4>Galleries:</h4>
                        <div class="form-group">
                            <label for="selcolWidth">Preview size:</label>
                            <select class="form-control" name="colWidth" id="selcolWidth">
                                <? foreach( \Components\Config::get('pic_column_image_width_options') as $key => $width): ?>
                                    <option <?= (int)$width === (int)\Components\Storage::get('colPicWidth') ? 'selected' : '' ?> <?='value='.$width ?>><?=$key; ?></option>
                                <? endforeach;?>
                            </select>
                        </div>                        
                        <div class="form-group">
                            <label for="groupTime">If next pic was created less then XXsec after previous pic, then they in one group:</label>
                            <input type="text" id="groupTime" name="groupTime" class="form-control" placeholder="" value="<?=\Components\Storage::get('groupTime')?:\Components\Config::get('within_one_group_seconds'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="colorScheme">Color scheme for personal gallery:</label>
                            <select class="form-control" name="colorScheme" id="colorScheme">
                                <? foreach( \Components\Config::get('color_schemes_incoming') as $key => $whatever): ?>
                                    <option <?= $key === \Components\Storage::get('colorScheme', \Components\Config::get('color_scheme_default')) ? 'selected' : '' ?>  <?='value="'.$key.'"' ?>><?=$key; ?></option>
                                <? endforeach;?>
                            </select>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="selpictureWidth">Picture size:</label>
                            <select class="form-control" name="pictureWidth" id="selpictureWidth">
                                <? foreach( \Components\Config::get('pictureWidthOptions') as $key => $width): ?>
                                    <? if (\Components\Storage::get('pictureWidth')) :?>
                                    <option <?= $width === \Components\Storage::get('pictureWidth') ? 'selected' : ''?> value="<?=$width?>"><?=$key?></option>
                                    <? else:?>
                                    <option <?= $width === \Components\Config::get('pictureWidthDefault') ? 'selected' : ''?> value="<?=$width?>"><?=$key?></option>
                                    <? endif;?>
                                <? endforeach;?>
                            </select>
                        </div>                        

                        <div class="form-group">
                            <label for="sidepanelOpacity">Sidepanel opacity:</label>
                            <select class="form-control" name="sidepanelOpacity" id="sidepanelOpacity">
                                <? foreach( \Components\Config::get('sidepanelOpacityOptions') as $key => $opacity ): ?>
                                    <? if (\Components\Storage::get('sidepanelOpacity')) :?>
                                    <option <?= $key === \Components\Storage::get('sidepanelOpacity') ? 'selected' : ''?> value="<?=$key?>"><?=$opacity?></option>
                                    <? else:?>
                                    <option <?= $key === \Components\Config::get('sidepanelOpacityDefault') ? 'selected' : ''?> value="<?=$key?>"><?=$opacity?></option>
                                    <? endif;?>
                                <? endforeach;?>
                            </select>
                        </div>                        


                        <div class="form-check">
                            <input type="hidden" name="showTooltips" value="0">
                            <input class="form-check-input changed" name="showTooltips" type="checkbox" id="showTooltips" <?=\Components\Storage::get('doNotShowTooltips')?'':'checked';?>>
                            <label class="form-check-label" for="showTooltips">
                                Show tooltips
                            </label>
                        </div>

                        <? if($this->isLoggedIn &&  $this->clan->update_token):?>
                        <hr>
                        <h6>StashPic update token - <?=$this->clan->update_token?></h6>
                        <?endif;?>
                        <br>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
        <script type="text/javascript">
            var skipFirstChangeTop = true;
            var skipFirstChangeBottom = true;

            function changeBackground() {
                var imgName = document.querySelector('#backgroundImage').value;
                var file = document.querySelector('.background-image-files[name='+imgName+']').getAttribute('file');

                var top = document.querySelector('#bodyGradientColorTop').value;
                var bottom = document.querySelector('#bodyGradientColorBottom').value;
                
                var cssText = "background-repeat: repeat;background: linear-gradient( " + top + ", " + bottom + " ), url('" + file + "');    background-attachment: fixed;";
                document.body.setAttribute("style", cssText);
            }

            var backgroundImageElement = document.querySelector('#backgroundImage');
            backgroundImageElement.addEventListener('change', (event) => {
                changeBackground();
            });

            function OnColorChanged(selectedColor, input) {
                if (input.id == "bodyGradientColorTop") {
                    if (skipFirstChangeTop) {
                        skipFirstChangeTop = false; // first change mades inside rgbaColorPicker.js 
                        return;
                    }
                    input.classList.add('changed');
                    changeBackground();
                }
                if (input.id == "bodyGradientColorBottom") {
                    if (skipFirstChangeBottom) {
                        skipFirstChangeBottom = false; // first change mades inside rgbaColorPicker.js 
                        return;
                    }
                    input.classList.add('changed');
                    changeBackground();
                }
            }
            
        </script>        
    </body>
</html>