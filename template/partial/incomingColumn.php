<? $tooltipClass = \Components\Storage::get('doNotShowTooltips')?'':'tooltip-target';?>
<?= \Components\Storage::get('doNotShowTooltips')?'':'<a class="column-label"> Personal gallery </a>';?>
<? foreach($pics as $pic):?>
<div>
    <div class="pic-preview" picId="<?=$pic->id?>" groupOrMarker="<?=$pic->group?>" picUrl="<?=\Components\Config::get('folders')['pic_uploads'].'/'.$pic->url?>" style="background: <?=$pic->color?>">
        <img class="preview" src="<?= '/'.\Components\Config::get('folders')['pic_previews'].'/'.$pic->preview ?>" >
        <img 
            class="picDelete <?=$tooltipClass?>"
            src="/assets/images/control/del.png"
            tooltip-class="tooltip-delete-screenshot" 
            tooltip-direction="down" 
            tooltip-align="left" 
        >
        <?if($this->map):?>
        <img 
            class="moveToMarker <?=$tooltipClass?>"
            src="/assets/images/control/to_marker.png"
            tooltip-class="tooltip-move-to-marker"
            tooltip-direction="down" 
            tooltip-align="left" 
        >
        
        <?
            $defaultMarkerType = (int)($_COOKIE['defaultMarkerType'] ?? 0);
            $filename = \Components\Config::get('defaultMarkerTypesAndTheirImages')[$defaultMarkerType];
        ?>
        <img 
            class="picNewMarker  <?=$tooltipClass?> tooltip-on-click"   
            src="<?=$filename?>"
            tooltip-class="tooltip-create-marker-type-<?=$defaultMarkerType?>" 
            tooltip-on-click-class="tooltip-on-click-select-place-on-the-map"
            tooltip-direction="down" 
            tooltip-align="left" 
        >
        <?endif;?>
    </div>
</div>    
<? endforeach; ?>

<span class='tooltip-simple tooltip-on-click-select-place-on-the-map'>Select place on the map and click to create a marker with group of screenshots </span>
<?foreach(\Components\Config::get('markerNamesAndTypes') as $typeName => $type): ?> 
    <span class='tooltip-simple tooltip-create-marker-type-<?=$type?>'>Create marker "<?=$typeName?>" <br>using a group of screenshots</span>
<? endforeach; ?>
