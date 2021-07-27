<?php

return [
    'css' => [
        'main.css' => '/assets/css/main.css',
        'map.css' => '/assets/css/map.css',
        'map-create.css' => '/assets/css/map-create.css',
        ],
    'js' => [
        'core.js' => '/assets/js/core.js',
        'map.js' => '/assets/js/map.js',
        'maps.js' => '/assets/js/maps.js',
        'map-create.js' => '/assets/js/map-create.js',
        'tooltip.js' => '/assets/js/tooltip.js',
    ],
    'routes' => [
        'task/([0-9]+)' => 'task/view/$1',
        'map/page/([0-9]+)' => 'map/page/$1',
        'map/add/picLoad' => 'user/addPictureByAppFile',
        'map/add/markerWithPic' => 'map/addMarker',
        'map/delete/pic' => 'map/deletePictures',
        'map/delete/marker' => 'map/deleteMarker',
        'map/refresh/marker' => 'map/refreshMarker',
        'map/pic/move/to/marker' => 'map/movePicsToMarker',
        'map/pic/move/to/incoming' => 'map/movePicsToIncoming',
        'map/getIncomingColumn' => 'map/getIncomingColumn',
        'map/showMarker' => 'map/getMarkerColumn',
        'map/getMapMarkers' => 'map/getMapMarkers',
        'map/marker/changeType' => 'map/changeMarkerType',
        
        'map/creation' => 'clan/mapCreation',
        'map/creationFile' => 'clan/mapCreationByUploadedFile',
        'clan/mapCreateImage' => 'clan/mapCreateImage',
        'clan/getMapPartsHash' => 'clan/getMapPartsHashAsString',
        'clan/maps' => 'clan/maps',
        // 'clan/delete/map/files/([0-9]+)' => 'clan/deleteMapAndEverythingRelatedToIt/$1', //idk what is this
        'clan/delete/map' => 'clan/deleteMap',
        'clan/undoDelete/map' => 'clan/undoDeleteMap',
        'clan/rename/map' => 'clan/renameMap',
        'clan/makeDefault/map' => 'clan/makeDefaultMap',
        'user/usertime' => 'user/getHourDiffBetweenUserAndServer',
        'user/logMarkerChangeType' => 'user/logMarkerChangeType',
        

        'stashpic/update/check' => 'user/updateCheck',
        'stashpic/update' => 'user/update',
        'stashpic' => 'user/stashpic',
        'speed-dial' => 'user/speedDial',
        'usi/([a-z0-9]+)' => 'user/usi/$1',
        'screenshots' => 'user/screenshots',
        
        'settings' => 'user/settings',
        'faq' => 'user/faq',
        'password-forgot' => 'clan/passwordForgot',
        'clan/settings' => 'clan/settings',
        'map' => 'map/map',
        'registration' => 'clan/registration',
        'logout' => 'clan/logout',
        '404' => 'clan/page404',
        'password-reset/([a-z0-9]+)/([_@\.A-Za-z0-9-])' => 'clan/passwordReset/$1/$2',
        'email/confirmation/request-check-mail' => 'clan/emailConfirmationRequestCheckMail',
        'email/confirmation/success' => 'clan/emailConfirmationSuccess',
        'email/confirmation/resend' => 'clan/resendConfirmationEmail',
        'user/following-link' => 'user/followingLink',
        


        // debug routes
        'lol' => 'map/lol',
        'test1' => 'user/test1',
        'user/cookies' => 'user/cookies',
        'user/session' => 'user/session',
        'user/cookieDelete' => 'user/cookieDelete',
        'user/sessionDelete' => 'user/sessionDelete',

        'actions' => 'user/userActions',
        '' => 'clan/login',
    ],
    'http_only_routes' => [
        '/map/add/picLoad',
        '/stashpic/update',
        '/stashpic/update/check',
    ],
    'db_params' => [
        'driver' => '',
        'user' => '',
        'password' => '',
        'dbname' => '',
        'host' => '127.0.0.1'
    ],
    'folders' => [
        'pic_previews' => 'content/preview',
        'pic_uploads' => 'content/uploads',
        'maps' => 'content/maps',
    ],
    'pic_column_image_width_options' => ['Smallest' => 150, 'Small' => 200, 'Medium' => 250, 'Large' => 300, 'Largest' => 400],
    'pic_column_image_width_max' => 400,
    'pic_column_image_width_default' => 250,
    'pictureWidthOptions' => ['Small' => '40', 'Medium' => '60', 'Large' => '80', 'Largest' => '100'],
    'pictureWidthDefault' => '100',
    'pic_preview_error_filename' => 'preview_error.png',
    'within_one_group_seconds' => 15, // if next pic was created less then 40sec after previous pic, then they in one group
    'password_cost' => 14,
    'color_schemes_incoming' => [
        'Pastel Rainbow' => ['#cc99c9','#9ec1cf','#9ee09e','#fdfd97','#feb144','#ff6663'],
        'Rainbow' => ['#9400d3','#4b0082','#0000ff','#00ff00','#ffff00','#ff7f00','#ff0000'],
        'This Is Love' => ['#b1b4ab','#dce5e2','#fd6e74','#b59d20','#fd0100','#2c0000'],
        'Adobe Apps Colors' => ['#FF0000','#FBB034','#FFDD00','#C1D82F','#00A4E4','#6A737B'],
        'Launceston City Flag' => ['#1B6614','#4FB81F','#EF180D','#F1EE00','#1F2587','#ABB7D0'],
        'I Like It' => ['#F96DAA','#FFBAE7','#FEFF00','#02D0FF','#F9C307','#5A82BE'],
        'Malaysia State' => ['#8CC2E3','#043E8A','#059B35','#FFFF02','#FFBAE7','#EC221C']
    ],
    'color_scheme_default' => 'Malaysia State',
    'sidepanelOpacityOptions' => [
        'opacity_0_pcnt' => '0%',
        'opacity_15_pcnt' => '15%',
        'opacity_30_pcnt' => '30%',
        'opacity_45_pcnt' => '45%',
        'opacity_60_pcnt' => '60%',
        'opacity_75_pcnt' => '75%',
        'opacity_90_pcnt' => '90%',
        'opacity_100_pcnt' => '100%',
    ],
    'sidepanelOpacityDefault' => 'opacity_75_pcnt',
    'default_clan_map' => '0',
    'stash_decay_hours' => 72,
    'upload' => [
        'pic' => [
            'map_part_max_file_size' => 30000000,
            'screenshot_max_file_size' => 2000000,
            'allowed_quantity_at_period' => 100,
            'period_in_minutes' => 15,
        ],
        'map' => [
            'map_max_file_size' => 70000000,
            'allowed_quantity_at_period' => 20,
            'period_in_minutes' => 60,
        ],
    ],
    'date_format' => 'd-m-Y H:i:s',
    'picTypes' => [
        'fullScreen' => '0',
        'centerScreen' => '1',
        'stashSlots' => '2',
        'mapPart' => '3',
    ],
    'number_of_pics_required_to_create_a_map' => 2,
    'map_creating_background_color' => '#2C3137',
    'test_first_map_filename' => 'map_example.png',
    'test_first_map_name' => 'Test map',
    'no_map_filename' => 'no_map.png',
    'no_map_no_registration_filename' => 'no_map_no_registration.png',
    'markerNamesAndTypes' => [
        'Stash' => 0,
        'Enemy base' => 1,
        'Blue marker' => 2,
    ],
    'markerTypesAndTheirImages' => [
        '0' => '/assets/images/sidepanel/change_marker/change_to_gold.png',
        '1' => '/assets/images/sidepanel/change_marker/change_to_green.png',
        '2' => '/assets/images/sidepanel/change_marker/change_to_blue.png',
    ],
    'defaultMarkerTypesAndTheirImages' => [
        '0' => '/assets/images/control/add_marker_gold.png',
        '1' => '/assets/images/control/add_marker_green.png',
        '2' => '/assets/images/control/add_marker_blue.png',
    ],
    'backgroundDefaultImage' => 'Pinetrees',
    'backgroundImages' => [
        'None' => '', 
        'Monstera' => '/assets/images/background/monstera_small.png',
        'Pinetrees' => '/assets/images/background/pinetrees.png',
        'Pebbles' => '/assets/images/background/pebbles/1036.png',
        'Wooden_floor' => '/assets/images/background/wooden floor.png',
        //'Wooden_patern' => '/assets/images/background/wood_pattern.png',
        //'Carbon_metal' => '/assets/images/background/Carbon_Metal/Background_02.png',
        //'Linen' => '/assets/images/background/linen.png',
        'Concreate' => '/assets/images/background/vintage-concrete.png',
        'Plastering' => '/assets/images/background/xv.png',
    ],
    'backgroundDefaultGradientColorTop' => 'rgba(0,0,0,0.9)',
    'backgroundDefaultGradientColorBottom' => 'rgba(51,204,102,0.2)',
    'email_password_reset_cooldown_minutes' => '15',
    'stashpicLatestVersion' => '1.0.2.0', // on server // <major>.<minor>.<patch>.<custom version(only for tier 4 patrons)>
    'actionTypes' => [
        'Logging as member' => '0',//entity_id - clan_id
        'Logging as clan leader' => '1',//entity_id - clan_id
        'Invalid logging' => '2', // data must contain error info and entered password, clan name
        'Setting USI by app link' => '3', 
        'Setting an USI' => '4',// data - usi
        'Setting an wallpaper' => '5',//data - wallpaper
        'Setting top gradient' => '6',//data - color as RGBA
        'Setting bottom gradient' => '7',//data - color as RGBA
        'Setting preview size' => '8',//data - keys from config pic_column_image_width_options
        'Setting color scheme' => '9',//data - keys from config color_schemes_incoming
        'Setting picture size' => '10',//data - keys from config pictureWidthOptions
        'Setting sidepanel opacity' => '11',//data - keys from config sidepanelOpacityOptions
        'Setting grouping seconds' => '12',//data - grouping seconds
        'Visit home page' => '13',
        'Visit register page' => '14',
        'Registration failed' => '15',//data - clanname, password, errors
        'Visit settings page' => '16',
        'Visit clan-settings page' => '17',
        'Visit faq page' => '18',
        'Visit email confirmation page' => '19',
        'Email confirmation token correct' => '20',
        'Email confirmation token incorrect' => '21',//data - entered token + error info
        'Visit map management page' => '22',
        'Visit map creation by in-game map page' => '23',
        'Visit map creating by image page' => '24',
        'Map creating by in-game map' => '25',
        'Map creating by image' => '26',
        'Delete map' => '27',
        'Delete marker(disable)' => '28',
        'Delete pic' => '29',
        'Creating marker' => '30',//data - imgs
        'Uploading image as entire screen' => '31',//data - width and height 
        'Uploading image as center' => '32',//data - width and height 
        'Uploading image as stash slots' => '33',//data - width and height 
        'Uploading image as map-part' => '34',//data - width and height 
        'Changing clan name' => '35',
        'Changing clan name error' => '36',
        'Changing member password' => '37',
        'Changing clan leader password' => '38',
        'First visit the stashmap' => '39',
        'Clicking on patreon' => '40',
        'Visit speed-dial' => '41',
        'Clicking on github stashpic' => '42',
        'Clicking on vid on stashpic page' => '43',
        'Marker type changing at marker' => '44',//entity_id, data - type
        'Marker type changing at sidepanel' => '45',//data - type
        'Downloading stashmap installer' => '46',
        'Downloading stashmap *.zip' => '47',
        'Downloading stashmap *.zip + sources' => '48',
        'Uploading image. Error : no usi given' => '49',
        'Uploading image. Error : too many screenshots. Try later' => '50',
        'Uploading image. Error : file not image' => '51',
        'Uploading image. Error : file too large' => '52',
        'Uploading image. Error : file not png or jpg' => '53',
        'Uploading image. Error : moving file fail' => '54',
        'Uploading image. Error : preview not created' => '55',
        'Selecting a marker' => '56',
        'Visit a map' => '57',
        'Move pics to marker' => '58',
        'Move pics to incoming' => '59',
        'Successful registration. Email confirmative token sended' => '60',
        'Clicking on discord' => '61',
        'Logout' => '62',
    ],
    'actionTypesCodes' => [
        '0' => 'Logging as member',//entity_id - clan_id
        '1' => 'Logging as clan leader',//entity_id - clan_id
        '2' => 'Invalid logging', // data must contain error info and entered password, clan name
        '3' => 'Setting USI by app link', 
        '4' => 'Setting an USI',// data - usi
        '5' => 'Setting an wallpaper',//data - wallpaper
        '6' => 'Setting top gradient',//data - color as RGBA
        '7' => 'Setting bottom gradient',//data - color as RGBA
        '8' => 'Setting preview size',//data - keys from config pic_column_image_width_options
        '9' => 'Setting color scheme',//data - keys from config color_schemes_incoming
        '10' => 'Setting picture size',//data - keys from config pictureWidthOptions
        '11' => 'Setting sidepanel opacity',//data - keys from config sidepanelOpacityOptions
        '12' => 'Setting grouping seconds',//data - grouping seconds
        '13' => 'Visit home page',
        '14' => 'Visit register page',
        '15' => 'Registration failed',//data - clanname, password, errors
        '16' => 'Visit settings page',
        '17' => 'Visit clan-settings page',
        '18' => 'Visit faq page',
        '19' => 'Visit email confirmation page',
        '20' => 'Email confirmation token correct',
        '21' => 'Email confirmation token incorrect',//data - entered token + error info
        '22' => 'Visit map management page',
        '23' => 'Visit map creation by in-game map page',
        '24' => 'Visit map creating by image page',
        '25' => 'Map creating by in-game map',
        '26' => 'Map creating by image',
        '27' => 'Delete map',
        '28' => 'Delete marker(disable)',
        '29' => 'Delete pic',
        '30' => 'Creating marker',//data - imgs
        '31' => 'Uploading  image as entire screen',//data - width and height 
        '32' => 'Uploading  image as center',//data - width and height 
        '33' => 'Uploading  image as stash slots',//data - width and height 
        '34' => 'Uploading  image as map-part',//data - width and height 
        '35' => 'Changing clan name',
        '36' => 'Changing clan name error',
        '37' => 'Changing member password',
        '38' => 'Changing clan leader password',
        '39' => 'First visit the stashmap',
        '40' => 'Clicking on patreon',
        '41' => 'Visit speed-dial',
        '42' => 'Clicking on github stashpic',
        '43' => 'Clicking on vid on stashpic page',
        '44' => 'Marker type changing at marker',//entity_id, data - type
        '45' => 'Marker type changing at sidepanel',//data - type
        '46' => 'Downloading stashmap installer',
        '47' => 'Downloading stashmap *.zip',
        '48' => 'Downloading stashmap *.zip + sources',
        '49' => 'Uploading image. Error : no usi given',
        '50' => 'Uploading image. Error : too many screenshots. Try later',
        '51' => 'Uploading image. Error : file not image', // filename
        '52' => 'Uploading image. Error : file too large', // filesize, filename
        '53' => 'Uploading image. Error : file not png or jpg', // filename
        '54' => 'Uploading image. Error : moving file fail', // filesize, filename
        '55' => 'Uploading image. Error : preview not created', // filesize, filename
        '56' => 'Selecting a marker',
        '57' => 'Visit a map',
        '58' => 'Move pics to marker',
        '59' => 'Move pics to incoming',
        '60' => 'Successful registration. Email confirmative token sended',
        '61' => 'Clicking on discord',
        '62' => 'Logout',
    ],
    'linkClickLeadToActions' => [
        'patreon' => 'Clicking on patreon',
        'github' => 'Clicking on github stashpic',
        'stashpic-vid' => 'Clicking on vid on stashpic page',
        'zip-and-sources' => 'Downloading stashmap *.zip + sources',
        'zip' => 'Downloading stashmap *.zip',
        'installer' => 'Downloading stashmap installer',
        'discord' => 'Clicking on discord',
    ],
    'demoClan' => 22,
    'tierMapCount' => [
        '0' => 2,
        '1' => 3,
        '2' => 5,
        '3' => 7,
    ],
    'tierMarkerCount' => [
        '0' => 50,
        '1' => 100,
        '2' => 150,
        '3' => 9000,
    ],
    'showRemainMarkersIfLessThenPercent' => 10,
    'ClanIdWithAnalyticPermission' => 81,
];
