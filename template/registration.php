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
            <a class=" btn-link" href="/">Back to login</a>
            <hr>

            <h2 class="hide">Getting Started with StashMap</h2>
            <iframe width="660" height="371" src="https://www.youtube.com/embed/J1jnpF1o0g4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <br>
            <br>
            <h2>Create a clan</h2>
            <hr>
            <? foreach($errors as $error) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$error;?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?endforeach;?>
            
            <form action="/registration" method='post'>
                <div class="form-group">
                    <label for="login">Pick a name for your clan:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter clan name" value="<?=$name?>">
                </div>
                <div class="form-group">
                    <label for="email">Email address(for password recovery only):</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?=$email?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Member password:</label>
                    <input type="password" name="userPassword" class="form-control" placeholder="Enter password" value="<?=$userPassword?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Clan leader password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" value="<?=$password?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Confirm clan leader password:</label>
                    <input type="password" name="passwordConfirm" class="form-control" placeholder="Enter password" value="<?=$passwordConfirm?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
</html>