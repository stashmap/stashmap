<div class="control-element">
    <div class="pic-preview top" picUrl="<?=$pics[1]->url?>" editorMapSelector=".map-parts-top">
        <img src="<?= '/'.\Components\Config::get('folders')['pic_previews'].'/'.$pics[1]->preview ?>" >
        <? $this->view('map/layerMovementControl'); ?>                
    </div>
</div>    
<div class="control-element">
    <div class="pic-preview bottom" picUrl="<?=$pics[0]->url?>" editorMapSelector=".map-parts-bottom">
        <img src="<?= '/'.\Components\Config::get('folders')['pic_previews'].'/'.$pics[0]->preview ?>" >
        <? $this->view('map/layerMovementControl'); ?>                
    </div>
</div>    
<div class="control-element">
    <hr>
</div>    
<div class="control-element">
    <div class="form-group">
        <label for="name">Map name:</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Enter clan name" value="">
    </div>
    <div class="form-check">
        <input class="form-check-input" name="defaultMap" type="checkbox" id="defaultMap" checked>
        <label class="form-check-label" for="defaultMap">
            Default clan's map
        </label>
    </div>
</div>    
<br>
<div class="control-element">
    <h6>Don't forget to adjust the boundaries</h6>
</div>
<br>
<div class="control-element">
    <div class="pic-preview create-map">
        <button type="submit" class="btn btn-primary">Create Map</button>
    </div>
</div>    
<div class="control-element">
    <hr>
</div>    

<div class="control-element">
    <a class=" btn-link" href="/clan/maps">Back to Maps Management</a>
</div>    