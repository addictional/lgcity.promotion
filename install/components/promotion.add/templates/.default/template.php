<?
use Bitrix\Main\Localization\Loc;
?>
<form class="promotion">
    <input type="hidden" name="props" value="<?=str_replace('"',"'",json_encode($arResult['PROPS']))?>">
    <input type="hidden" name="AJAX" value="<?=$arParams['COMPONENT_URI']."/ajax.php"?>">
    <input type="hidden" value="<?=$arParams['IBLOCK']?>" name="IBLOCK">
    <input type="hidden" value="<?=$arParams['PROPERS']?>" name="PROP_ID">
	<label class="properties" for="name"><?=Loc::getMessage('PROMOTION_NAME_DESC')?>
		<input type="text" name="NAME" id="name" required >
	</label>
	<label class="properties"><?=Loc::getMessage('DATE_OF')?></label>
	<div class = "date">
		<p> <?=Loc::getMessage('DATE_OF_FROM')?> </p>
		<div class="date-input" >	
		<input placeholder="11/09/1995" type="tel" name="DATE_FROM" class="date-date" id="date-from-date" required="" >
	    <input placeholder="11:59:59" type="tel" name="DATE_FROM_time" class="date-time"" id="date-from-time" required="">
		</div>
		<p> <?=Loc::getMessage('DATE_OF_TO')?> </p>
		<div class="date-input" >	
		<input placeholder="11/09/1995" type="tel" name="DATE_TO" class="date-date" id="date-to-date" required="" >
	    <input placeholder="11:59:59" type="tel" name="DATE_TO_time" class="date-time"" id="date-to-time" required="">
		</div>
    </div>
	<label class="properties" for="preview-picture"><?=Loc::getMessage('PICTURE_FOR_MAIN_SLIDER')?> </label>
	<div class="drop-area">
			<a href="#" class="close"></a>
			<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                <path d="M19.5 13c-2.483 0-4.5 2.015-4.5 4.5s2.017 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.017-4.5-4.5-4.5zm2.5 5h-2v2h-1v-2h-2v-1h2v-2h1v2h2v1zm-7.18 4h-14.82v-20h7c1.695 1.942 2.371 3 4 3h13v7.82c-.576-.554-1.252-1.006-2-1.319v-4.501h-11c-2.34 0-3.537-1.388-4.916-3h-4.084v16h11.502c.312.749.765 1.424 1.318 2z"/>
            </svg>
		<img >	
	</div>
	<label class="properties" ><?=Loc::getMessage('PICTURE_FOR_TOPIC')?> </label>
	<div class="drop-area">
			<a href="#" class="close"></a>
			<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                <path d="M19.5 13c-2.483 0-4.5 2.015-4.5 4.5s2.017 4.5 4.5 4.5 4.5-2.015 4.5-4.5-2.017-4.5-4.5-4.5zm2.5 5h-2v2h-1v-2h-2v-1h2v-2h1v2h2v1zm-7.18 4h-14.82v-20h7c1.695 1.942 2.371 3 4 3h13v7.82c-.576-.554-1.252-1.006-2-1.319v-4.501h-11c-2.34 0-3.537-1.388-4.916-3h-4.084v16h11.502c.312.749.765 1.424 1.318 2z"/>
            </svg>
		<img >	
	</div>
	<label class="properties" ><?=Loc::getMessage('TEXT_OF_TOPIC')?><strong id="add-text"><?=Loc::getMessage('ADD')?></strong></label>
	<div id ="detail-text">
	</div>
	<label class="properties" for="type"><?=Loc::getMessage('TYPE_OF_DISCOUNT')?></label>
	<select id="type" name="DISCOUNT_TYPE">
		<option ><?=Loc::getMessage('TYPE_OF_DISCOUNT_2')?></option>
		<option value="Perc"><?=Loc::getMessage('PERCENT')?>(%)</option>
		<option value="CurEach"><?=Loc::getMessage('RUB')?></option>
	</select>
	<label class="properties" for="discount-amount"><?=Loc::getMessage('AMOUNT_OF_DISCOUNT')?>
		<input type="number" name="DISCOUNT_AMOUNT" id="discount-amount">
	</label>
	<label class="properties" for="discount-coupon"><?=Loc::getMessage('PROMOTION_COUPON')?>
		<input type="text" name="DISCOUNT_COUPON" id="discount-coupon">
	</label>
	<label for='season-discount' class="properties">Дейстует на товары с сезонной скидкой </label>
	<select id='season-discount'>
        <?foreach ($arResult['PROPS'] as $prop){?>
        <option value="<?=$prop?>" id="<?=$prop?>" tytle="<?=$prop?>"><?=$prop?></option>
        <?}?>
    </select>
	<label class="properties" for="code-of-document">Код документа в свойстве акция
		<input type="text" name="CODE_OF_DOCUMENT" id="code-of-document">
	</label>
	<label class="properties radio" for="abandoned-card">Отключить скидку за брошенную корзину
		<input type="checkbox" name="ABANDONED_CARD" id="abandoned-card">
	</label>
	<label class="properties radio" for="discount-registr">Отключить скидку за регистрацию
		<input type="checkbox" name="DISCOUNT_REGISTR" id="discount-registr">
	</label>
	<label class="properties" for="text-line">Текст для акицонной полоски
		<input type="text" name="TEXT_LINE" id="text-line">
	</label>
    <label class="properties" for="href-text-line">Ссылка для полоски
        <input type="text" name="HREF_TEXT_LINE" id="href-text-line">
    </label>
	<label class="properties" for='styles-for-textline' class="properties">Шрифт, размер шрифта, цвет шрифта</label>
	<select id='styles-for-textline'></select>
	<label class="properties radio" for="reset-cache">Сбросить кеш при старте акции?
		<input type="checkbox" name="RESET_CACHE" id="reset-cache">
	</label>
	<button type="submit">Применить</button>
</form>	
<? ?>