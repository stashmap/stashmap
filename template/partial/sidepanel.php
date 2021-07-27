        <div id="sidepanel" class="<?=\Components\Storage::get('sidepanelOpacity')?? \Components\Config::get('sidepanelOpacityDefault') ?>">
            <? if (!$this->isLoggedIn): ?>
            <a href="/">
                <img 
                    src="/assets/images/sidepanel/login.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-login" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <a href="/registration">
                <img 
                    src="/assets/images/sidepanel/new_clan.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-registration" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <?endif;?>
            
            <a href="/settings" >
                <img 
                    src="/assets/images/sidepanel/settings.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-settings" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <? if ($this->isMaster): ?>
            <a href="/clan/settings" >
                <img 
                    src="/assets/images/sidepanel/clan-settings.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-clan-settings" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <? endif;?>

            <? if ($this->isMaster): ?>
            <? if ($usi): ?>
                <? $defaultMarkerType = (int) ($_COOKIE['defaultMarkerType'] ?? 0); ?>
                <a>
                    <img 
                        src="<?=\Components\Config::get('markerTypesAndTheirImages')[$defaultMarkerType] ?>" 
                        type="<?=$defaultMarkerType?>" 
                        class="default-marker-type-changer <?=$tooltipClass?>" 
                        marker-option-class="default-marker-type-option"
                        tooltip-class="tooltip-default-marker" 
                        tooltip-direction="left" 
                        tooltip-align="left" 
                    >
                    <img 
                        src="<?=\Components\Config::get('markerTypesAndTheirImages')[\Components\Config::get('markerNamesAndTypes')['Stash']] ?>" 
                        type="<?=\Components\Config::get('markerNamesAndTypes')['Stash'] ?>" 
                        class="default-marker-type-option marker-type-option hide <?=$tooltipClass?>"
                        marker-option-class="default-marker-type-option"
                        tooltip-class="tooltip-stash-marker" 
                        tooltip-direction="up" 
                        tooltip-align="left"
                    >
                    <img 
                        src="<?=\Components\Config::get('markerTypesAndTheirImages')[\Components\Config::get('markerNamesAndTypes')['Enemy base']] ?>" 
                        type="<?=\Components\Config::get('markerNamesAndTypes')['Enemy base'] ?>" 
                        class="default-marker-type-option marker-type-option hide <?=$tooltipClass?>"
                        marker-option-class="default-marker-type-option"
                        tooltip-class="tooltip-base-marker" 
                        tooltip-direction="up" 
                        tooltip-align="left"
                    >
                    <img 
                        src="<?=\Components\Config::get('markerTypesAndTheirImages')[\Components\Config::get('markerNamesAndTypes')['Blue marker']] ?>" 
                        type="<?=\Components\Config::get('markerNamesAndTypes')['Blue marker'] ?>" 
                        class="default-marker-type-option marker-type-option hide <?=$tooltipClass?>"
                        marker-option-class="default-marker-type-option"
                        tooltip-class="tooltip-blue-marker" 
                        tooltip-direction="up" 
                        tooltip-align="left"
                    >
                </a>
            <? endif; ?>
            <? endif;?>
            
            <a href="/stashpic" target="_blank">
                <img 
                    src="/assets/images/sidepanel/app.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-download-page" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            
            <a href="/faq" target="_blank">
                <img 
                    src="/assets/images/sidepanel/faq.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-faq" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <a href="/speed-dial">
                <img 
                    src="/assets/images/sidepanel/rust_related_websites.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-rust-websites" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <a href="https://www.patreon.com/stashmap" target="_blank" link-to="patreon">
                <img 
                    src="/assets/images/sidepanel/patreon.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-patreon"
                    tooltip-direction="left"
                    tooltip-align="left"
                >
            </a>
            <a href="https://discord.gg/jvWCFBaQBA" target="_blank" link-to="discord">
                <img 
                    src="/assets/images/sidepanel/discord.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-discord"
                    tooltip-direction="left"
                    tooltip-align="left"
                >
            </a>
            <? if ($this->isLoggedIn): ?>
           
            <a href="/logout" link-to="logout">
                <img 
                    src="/assets/images/sidepanel/logout.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-logout" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <?endif;?>
            
            <? if ($this->clan->id === \Components\Config::get('ClanIdWithAnalyticPermission')): ?>
            <a href="/user/cookies" target="_blank">
                <img 
                    src="/assets/images/sidepanel/cookie.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-cookie" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <a href="/user/session" target="_blank">
                <img 
                    src="/assets/images/sidepanel/cookie.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-session" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <a href="/actions" target="_blank">
                <img 
                    src="/assets/images/sidepanel/info.png"
                    class="<?=$tooltipClass?>"
                    tooltip-class="tooltip-session" 
                    tooltip-direction="left" 
                    tooltip-align="left" 
                >
            </a>
            <?endif;?>
        </div>
        <span class="tooltip-simple tooltip-settings">Settings</span>
        <span class="tooltip-simple tooltip-clan-settings">Clan settings</span>
        <span class="tooltip-simple tooltip-default-marker">New marker will be</span>
        <span class="tooltip-simple tooltip-stash-marker">Stash</span>
        <span class="tooltip-simple tooltip-base-marker">Enemy base</span>
        <span class="tooltip-simple tooltip-blue-marker">Blue marker</span>
        <span class="tooltip-simple tooltip-download-page">Application for sending screenshots</span>
        <span class="tooltip-simple tooltip-faq">All answers are here</span>
        <span class="tooltip-simple tooltip-rust-websites">Useful Rust-related websites</span>
        <span class="tooltip-simple tooltip-patreon">Patreon</span>
        <span class="tooltip-simple tooltip-discord">Give us feedback on discord</span>
        <span class="tooltip-simple tooltip-logout">Logout</span>
        <span class="tooltip-simple tooltip-login">Join a clan</span>
        <span class="tooltip-simple tooltip-registration">Create a clan</span>
        <span class="tooltip-simple tooltip-cookie">Manage Cookies!</span>
        <span class="tooltip-simple tooltip-session">Manage session</span>

        <span class="tooltip-simple tooltip-delete-screenshot">Delete screenshot</span>
        <span class="tooltip-simple tooltip-move-to-marker">Move screenshot <br>to selected marker</span>
        <span class="tooltip-simple tooltip-move-to-incoming">Move screenshot <br>to personal gallery</span>

        