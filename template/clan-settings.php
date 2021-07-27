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
            <div class="settings get-user-local-time">

                <div class="mainWrapper">
                    <a class=" btn-link" href="/map">Back to Map</a>
                    <hr>
                    <h2>Clan Settings</h2>
                    <a class=" btn-link" href="/clan/maps">Maps Management</a>

                    <? foreach($successMessages as $message) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?=$message;?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?endforeach;?>

                    <? foreach($errors as $error) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?=$error;?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?endforeach;?>

                    <form method='post'>
                        <div class="form-group">
                            <label for="name">Clan name:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter clan name" value="<?=$clanName; ?>">
                        </div>

                        <hr>
                        <h4>Member password</h4>
                        <div class="form-group">
                            <label for="userPassword">Enter new member password:</label>
                            <input type="password" id="userPassword" name="userPassword" class="form-control" placeholder="Enter clan user password" value="">
                        </div>

                        <div class="form-group">
                            <label for="userPasswordConfirmation">Enter new member password confirmation:</label>
                            <input type="password" id="userPasswordConfirmation" name="userPasswordConfirmation" class="form-control" placeholder="Enter clan user password confirmation" value="">
                        </div>

                        <div class="form-group">
                            <label for="masterPasswordUser">Enter clan leader password :</label>
                            <input type="password" id="masterPasswordUser" name="masterPasswordUser" class="form-control" placeholder="Enter clan master password" value="">
                        </div>

                        <hr>
                        <h4>Clan leader password</h4>
                        <div class="form-group">
                            <label for="newMasterPassword">Enter new clan leader password:</label>
                            <input type="password" id="newMasterPassword" name="newMasterPassword" class="form-control" placeholder="Enter new master password" value="">
                        </div>

                        <div class="form-group">
                            <label for="newMasterPasswordConfirmation">Enter new clan leader password confirmation:</label>
                            <input type="password" id="newMasterPasswordConfirmation" name="newMasterPasswordConfirmation" class="form-control" placeholder="Enter new master password confirmation" value="">
                        </div>

                        <div class="form-group">
                            <label for="masterPasswordMaster">Enter current clan leader password :</label>
                            <input type="password" id="masterPasswordMaster" name="masterPasswordMaster" class="form-control" placeholder="Enter clan master password" value="">
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>