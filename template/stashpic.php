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
            <div class="settings">
                <div class="mainWrapper">
                    <a class="btn-link" href="<?=\Components\Storage::get('backTo_Link')?>"><?=\Components\Storage::get('backTo_Label')?></a>
                    <hr>
                    <h1>StashPic</h1>
                    <p>
                        <a link-to="installer" href="/content/stashpic/StashPic_Setup_1.0.2.exe" download><b>Download StashPic <?=$version?> for Windows</b></a></td>
                    </p>  
                    
                    <table cellspacing="1" cellpadding="6" border="0" class="table table-bordered hide">
                    <tbody><tr>
                        <th class="Title" align="center">Description</th>
                        <th class="Title" align="center" width="60">Link</th>
                        <th class="Title" align="center" width="60">Type</th>
                    </tr>
                    <tr>
                        <td class="Item">Windows Installer</td>
                        <td class="Item" align="center"><a link-to="installer" href="/content/stashpic/StashPic_Setup_1.0.2.exe" download>Download</a></td>
                        <td class="Item" align="center">.exe</td>
                    </tr>
                    <tr>
                        <td class="Item">Zip archive + source code</td>
                        <td class="Item" align="center"><a link-to="zip-and-sources" href="/content/stashpic/StashPic.exe" download>Download</a></td>
                        <td class="Item" align="center">.exe</td>
                    </tr>
                    <tr>
                        <td class="Item">Zip archive</td>
                        <td class="Item" align="center"><a link-to="zip" href="/content/stashpic/StashPic.zip" download>Download</a></td>
                        <td class="Item" align="center">.zip</td>
                    </tr>
                    </tbody>
                    </table>
                    <p>StashPic allows you to take screenshots during the game using hotkeys and automatically sends them to the stashmap.net site, where they are used to create markers on the map.</p>  
                    <hr>
                    
                    <h3>StashPic is an open source project</h3>
                    <p> The source code is available on <a link-to="github" href="https://github.com/stashmap/StashPic">GitHub</a></p>  
                    <p>Download the FREE Delphi Comunity Edition <a href="https://www.embarcadero.com/products/delphi/starter/free-download?aldSet=en-GB">here</a> to compile the application if you want</p>  
                    
                </div>
            </div>
        </div>
    </body>
</html>