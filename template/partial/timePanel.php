<?php        
$now = new \DateTime();
$decayDate = clone $marker->refresh_time;
$decayDate->add( new \DateInterval('PT'.\Components\Config::get('stash_decay_hours').'H')); 
if ($marker->type === \Components\Config::get('markerNamesAndTypes')['Stash']) {
    if ($now > $decayDate) {
        echo "<p>Status : decayed</p>";
    } else {
        echo "<p>".\Components\DateHelper::formatDateDiff($decayDate)." to decay</p>";
    }
}
echo "<p>".\Components\DateHelper::formatDateDiff($marker->refresh_time)." old</p>";
