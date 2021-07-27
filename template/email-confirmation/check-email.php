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

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="<?=\Components\Config::get('css')['main.css']?>">
        <script src="<?=\Components\Config::get('js')['core.js']?>"></script>        
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
                    <h1>Email confirmation:</h1>
                    <? foreach($errors as $error) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?=$error;?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?endforeach;?>

                    <p> A token has been sent to you in an email to <?=$email?>. Check spam folder. Copy it from email and paste it into the box below</p>
                    
                    <form method='post'>
                        <div class="form-group">
                            <label for="token">Token from email:</label>
                            <input type="text" id="token" name="token" class="form-control" value="">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <hr>
                    <? if(!$resendTime): ?> 
                        <a class=" btn-link" href="/email/confirmation/resend">Resend confirmation email</a>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>