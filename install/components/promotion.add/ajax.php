<?php

use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Carbon\Carbon;

define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('NOT_CHECK_PERMISSIONS', true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
$class = str_replace('ajax.php','class.php',__FILE__);
require_once ($class);
if(!isset($_REQUEST['ajax'])) die();
if(!Loader::includeModule('lgcity.promotion'))die();
$db = new \Lgcity\Promotion\Base\Database();


$discountId = AddPromotion::addDiscount();
if(isset($_REQUEST['DISCOUNT_COUPON']) && $discountId )
{
    $arCouponFields = [
        'DISCOUNT_ID' => $discountId,
        'ACTIVE' => 'Y',
        'COUPON' => trim($_REQUEST['DISCOUNT_COUPON']),
        'TYPE' => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_MULTI_ORDER,
        'MAX_USE' => 10000,
    ];
    $couponId = \Bitrix\Sale\Internals\DiscountCouponTable::add($arCouponFields);
    AddPromotion::$discount->setCoupon('Y');
    AddPromotion::refreshDiscount();
}
    AddPromotion::addPromotion($discountId);



