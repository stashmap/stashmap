<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

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
            <h2>What is StashMap?</h2>
            <iframe width="660" height="371" src="https://www.youtube.com/embed/X0TgoWXdsZw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <br>
            <form method='post'>
                <h2>Join an existing clan</h2>
                <hr>                
            <? foreach($errors as $error) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$error;?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?endforeach;?>

                <div class="form-group">
                    <label for="login">Clan name or e-mail:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter clan name" value="<?=$name?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" value="<?=$password?>">
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" name="rememberMe" type="checkbox"> Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href='/password-forgot'> Forgot password? </a>
                <hr>
                <a class="registrationLink" href='/registration'> Create a clan </a>
            </form>
        </div>
    </body>
</html>