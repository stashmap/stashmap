<? $tooltipClass = \Components\Storage::get('doNotShowTooltips')?'':'tooltip-target';?>
<table class="map-layers-control" cellspacing="0" cellpadding="0">
    <tr>
        <td></td>
        <td>
            <img 
            class="control-to-move-one-px-up <?=$tooltipClass?>"
            src="/assets/images/control/mapCreation/up.png"
                tooltip-class="tooltip-move-up" 
                tooltip-direction="right" 
                tooltip-align="right"
            >
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <img 
                class="control-to-move-one-px-left <?=$tooltipClass?>"
                src="/assets/images/control/mapCreation/left.png"
                tooltip-class="tooltip-move-left" 
                tooltip-direction="right" 
                tooltip-align="right"
            >
        </td>
        <td>
        </td>
        <td>
            <img 
                class="control-to-move-one-px-right <?=$tooltipClass?>"
                src="/assets/images/control/mapCreation/right.png"
                tooltip-class="tooltip-move-right" 
                tooltip-direction="down" 
                tooltip-align="right"
            >
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <img 
                class="control-to-move-one-px-down <?=$tooltipClass?>" 
                src="/assets/images/control/mapCreation/down.png"
                tooltip-class="tooltip-move-down" 
                tooltip-direction="right" 
                tooltip-align="right"
            >
        </td>
        <td></td>
    </tr>
</table>