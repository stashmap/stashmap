<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/tooltip.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="<?=\Components\Config::get('css')['main.css']?>">
        <link rel="stylesheet" href="/assets/css/maps.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="<?=\Components\Config::get('js')['core.js']?>"></script>                
        <script src="<?=\Components\Config::get('js')['maps.js']?>"></script>                
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

                <div class="mainWrapper">
                    <a class="btn-link" href="/clan/settings">Back to Clan Settings</a>
                    <hr>
                    <h2>Maps Management</h2>
                    <? if($canCreateMaps):?>
                        <p>
                            <a class=" btn-link <?= \Components\Storage::get('usi') ? '' : 'disabled'; ?>" href="/map/creation">Сreating a map using the in-game map</a>
                            <?= \Components\Storage::get('usi') ? '' : '<p class="text-danger">You can\'t create map without pair browser to app. Enter USI(Application Unique Sender Id) at <a href="/settings">settings page</a></p>'; ?>
                        </p>
                        <p>
                            <a class=" btn-link" href="/map/creationFile">Сreating a map using an image</a>
                        </p>
                    <? else:?>
                        <p class="text-danger">
                            You have reached the map limit for the clan. Remove some map to be able to create another one 
                        </p>
                    <? endif;?>

                    <? if(count($maps)>0):?>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Created</th>
                        <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? $tooltipClass = \Components\Storage::get('doNotShowTooltips')?'':'tooltip-target';?>
                    <? foreach($maps as $map) : ?>
                        <tr mapId="<?=$map->id?>">
                            <td>
                                <span class="mark-for-deletion hide">For deletion</span>
                                <div class="input-group">
                                    <input class="form-control mapname" value="<?=$map->name?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-light save-button disabled">Saved</button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="mark-for-deletion hide">For deletion</span>
                                <span class="created">
                                <?
                                    $date = clone $map->created;
                                    $hourDiff = (int)$_COOKIE['hourDiff'];
                                    $invertion = $hourDiff < 0 ? 1 : 0;
                                    $hourDiff = abs($hourDiff);
                                    $interval = new \DateInterval('PT'.$hourDiff.'H');
                                    $interval->invert = $invertion;
                                    echo $date->add($interval)->format(\Components\Config::get('date_format'));
                                ?>
                                </span>
                            </td>
                            <td>
                                <img 
                                    class="control delete <?=$tooltipClass?>" 
                                    src="/assets/images/control/del.png"
                                    tooltip-class="tooltip-delete" 
                                    tooltip-direction="down" 
                                    tooltip-align="right" 
                                >
                                <img 
                                    class="control makeDefault  <?=$tooltipClass?>" 
                                    src="/assets/images/control/<?= $map->id === $this->clan->current_map_id ? 'check.png' : 'uncheck.png' ?>"
                                    tooltip-class="tooltip-make-default" 
                                    tooltip-direction="down" 
                                    tooltip-align="right" 
                                >
                                <a href="<?='/'.\Components\Config::get('folders')['maps'].'/'.$map->map_filename?>" target="_blank">
                                    <img 
                                        class="control show <?=$tooltipClass?>" 
                                        src="/assets/images/control/view.png"
                                        tooltip-class="tooltip-view" 
                                        tooltip-direction="down" 
                                        tooltip-align="right" 
                                    >
                                </a>
                                <span class="tooltip-simple tooltip-view">View map</span>
                                <span class="tooltip-simple tooltip-make-default">Make this map as<br> default clan's map</span>
                                <span class="tooltip-simple tooltip-delete">Delete map. Can't be undone</span>
                            </td>
                        </tr>
                    <?endforeach;?>
                    </tbody>
                    </table>
                    <? endif;?>
                </div>
            </div>
        </div>
    </body>
</html>