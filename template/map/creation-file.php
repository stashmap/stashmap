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
        <script src="<?=\Components\Config::get('js')['maps.js']?>"></script>                

    </head>
    <?
        $gradientColorTop = \Components\Storage::get('bodyGradientColorTop',\Components\Config::get('backgroundDefaultGradientColorTop'));
        $gradientColorBottom = \Components\Storage::get('bodyGradientColorBottom',\Components\Config::get('backgroundDefaultGradientColorBottom'));
        $backgroundPictureName = \Components\Storage::get('backgroundImage',\Components\Config::get('backgroundDefaultImage'));
        $backgroundPictureFilename = \Components\Config::get('backgroundImages')[$backgroundPictureName];
    ?>
    <body style="background-repeat: repeat;background: linear-gradient( <?=$gradientColorTop?>, <?=$gradientColorBottom?> ), url('<?=$backgroundPictureFilename?>'); background-attachment: fixed;">
        <div class="page">
            <div class="settings create-map-from-file">
                <div class="mainWrapper">
                    <a class=" btn-link" href="/clan/maps">Back to Maps Management</a>
                    <hr>
                    
                    <h2>Сreating a map using an image</h2>

                    <? foreach($errors as $error) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?=$error;?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?endforeach;?>

                    <form method='post' enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="name">Map name:</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter map name" value="">
                            </div>
                            <div class="form-group">
                                <label for="fileToUpload">Select image to upload:</label>
                                <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="defaultMap" type="checkbox" id="defaultMap" checked>
                                <label class="form-check-label" for="defaultMap">
                                    Default clan's map
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Map</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>