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
    </head>
    <?
        $gradientColorTop = \Components\Storage::get('bodyGradientColorTop',\Components\Config::get('backgroundDefaultGradientColorTop'));
        $gradientColorBottom = \Components\Storage::get('bodyGradientColorBottom',\Components\Config::get('backgroundDefaultGradientColorBottom'));
        $backgroundPictureName = \Components\Storage::get('backgroundImage',\Components\Config::get('backgroundDefaultImage'));
        $backgroundPictureFilename = \Components\Config::get('backgroundImages')[$backgroundPictureName];
    ?>
    <body style="background-repeat: repeat;background: linear-gradient( <?=$gradientColorTop?>, <?=$gradientColorBottom?> ), url('<?=$backgroundPictureFilename?>'); background-attachment: fixed;">
        <div class="mainWrapper">
            <h2>Password reset</h2>
            <hr>
            <? foreach($errors as $error) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$error;?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?endforeach;?>
            
            <? if($passwordChanged): ?>
                <div class="alert alert-success" role="alert"> Success! Password has been changed!</div>
                <br>
                <a class="btn-link" href="/">Back to login</a>
            <? else: ?>
                <form method='post'>
                    <div class="form-group">
                        <label for="password">New password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" value="">
                    </div>                
                    <div class="form-group">
                        <label for="passwordConfirmation">Password confirmation:</label>
                        <input type="passwordConfirmation" name="passwordConfirmation" class="form-control" placeholder="Enter password confirmation" value="">
                    </div>                
                    <button type="submit" class="btn btn-primary">Save password</button>
                </form>
            <? endif; ?>

        </div>
    </body>
</html>

