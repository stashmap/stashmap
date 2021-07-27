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
            <a class=" btn-link" href="/">Back to login</a>
            <hr>

            <h2>Forgot Password</h2>
            <hr>
            <? foreach($errors as $error) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$error;?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?endforeach;?>
            
            <? if($emailSended): ?>
            <div class="alert alert-success" role="alert"> Success! Please check your email for a reset link.</div>
            <? else: ?>
                <p>
                    Forgotten your password? Enter your email address below and we'll send you an email with instructions on how to reset it.
                </p>
                <form method='post'>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" value="">
                    </div>                
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </form>
            <? endif; ?>

        </div>
    </body>
</html>

