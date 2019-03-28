<?php
?>
<?if($arResult != null){?>
<div class="stripe" style="background: <?=$arResult->UF_BACKGROUND_COLOR?>;">
    <a href="<?=$arResult->UF_LINK?>">
        <p style="color: <?=$arResult->UF_FONT_COLOR?>; font-weight: bold;
            font-family: HelveticaLight;"><?=$arResult->UF_ROW_TEXT?></p>
    </a>
</div>
<?}?>