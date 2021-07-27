<?
// v($_SESSION); for debug information
// v(\Components\Config::get('markerNamesAndTypes')['Stash']);
// v(\Components\Storage::get('doNotShowTooltips'));
if (
    true
    // false
    ):


?>

<? $tooltipClass = \Components\Storage::get('doNotShowTooltips') ? '' : 'tooltip-target';?>

<?= \Components\Storage::get('doNotShowTooltips')?'':'<a class="column-label"> Marker\'s gallery </a>';?>
<? foreach($pics as $pic):?>
<div class="portlet">
    <div class="pic-preview" picId="<?=$pic->id?>" groupOrMarker="<?= $marker->id?>" picUrl="<?=\Components\Config::get('folders')['pic_uploads'].'/'.$pic->url?>" >
        <img class="preview" src="<?= '/'.\Components\Config::get('folders')['pic_previews'].'/'.$pic->preview ?>">
        <? If ($usi === $pic->usi):?>
        <img 
            class="moveToIncoming <?=$tooltipClass?>"
            src="/assets/images/control/to_incoming.png"
            tooltip-class="tooltip-move-to-incoming"
            tooltip-direction="down" 
            tooltip-align="left" 
        >
        <? endif;?>
        <img 
            class="picDelete <?=$tooltipClass?>"
            src="/assets/images/control/del.png"
            tooltip-class="tooltip-delete-screenshot" 
            tooltip-direction="down" 
            tooltip-align="left" 
        >
    </div>
</div>
<? endforeach; ?>
<div class="portlet">
    <div class="marker-info">
        <div class="time-panel">
        </div>
        <div class="marker-control">
            <img 
                src="/assets/images/control/marker/delete.png" 
                class="delete <?=$tooltipClass?>" 
                markerId="<?= $marker->id?>"
                tooltip-class="tooltip-delete-marker" 
                tooltip-direction="up"
                tooltip-align="left"
            >
            <img 
                src="<?=\Components\Config::get('markerTypesAndTheirImages')[$marker->type] ?>" 
                type="<?=$marker->type?>" 
                class="marker-type-changer <?=$tooltipClass?>" 
                marker-option-class="selected-marker-type-option"
                tooltip-class="tooltip-marker-type" 
                tooltip-direction="up"
                tooltip-align="right"
            >
            <img 
                src="/assets/images/control/marker/refresh_time.png" 
                class="refresh-time <?=$tooltipClass?>" 
                markerId="<?= $marker->id?>"
                tooltip-class="tooltip-refresh-marker" 
                tooltip-direction="down" 
                tooltip-align="right"
            >
                
            <img 
                src="<?=\Components\Config::get('markerTypesAndTheirImages')[\Components\Config::get('markerNamesAndTypes')['Stash']] ?>" 
                type="<?=\Components\Config::get('markerNamesAndTypes')['Stash'] ?>" 
                class="selected-marker-type-option marker-type-option hide <?=$tooltipClass?>"
                marker-option-class="selected-marker-type-option"
                tooltip-class="tooltip-stash-marker" 
                tooltip-direction="left" 
                tooltip-align="left"
            >
            <img 
                src="<?=\Components\Config::get('markerTypesAndTheirImages')[\Components\Config::get('markerNamesAndTypes')['Enemy base']] ?>" 
                type="<?=\Components\Config::get('markerNamesAndTypes')['Enemy base'] ?>" 
                class="selected-marker-type-option marker-type-option hide <?=$tooltipClass?>"
                marker-option-class="selected-marker-type-option"
                tooltip-class="tooltip-base-marker" 
                tooltip-direction="left" 
                tooltip-align="left"
            >
            <img 
                src="<?=\Components\Config::get('markerTypesAndTheirImages')[\Components\Config::get('markerNamesAndTypes')['Blue marker']] ?>" 
                type="<?=\Components\Config::get('markerNamesAndTypes')['Blue marker'] ?>" 
                class="selected-marker-type-option marker-type-option hide <?=$tooltipClass?>"
                marker-option-class="selected-marker-type-option"
                tooltip-class="tooltip-blue-marker" 
                tooltip-direction="left" 
                tooltip-align="left"
            >

            <span class="tooltip-simple tooltip-refresh-marker">Refresh marker time</span>
            <span class="tooltip-simple tooltip-marker-type">Change marker type</span>
            <span class="tooltip-simple tooltip-delete-marker">Delete marker</span>

        </div>
    </div>
</div>

<div class="markers-remain hide">
</div>
<? endif; ?>