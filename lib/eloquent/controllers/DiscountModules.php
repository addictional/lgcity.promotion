<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 13.03.2019
 * Time: 14:33
 */

namespace Lgcity\Promotion\Eloquent\Controllers;

use \Lgcity\Promotion\Eloquent\Models as PromotionModels;

class DiscountModules
{
    const MODULE_ID = 'catalog';

    //
    public static function add($discountId)
    {
        $check = PromotionModels\DiscountModule::Where(['DISCOUNT_ID'=>$discountId])->get();
        if(count($check)>0)
            return false;
        $row = PromotionModels\DiscountModule::create();
        $row->DISCOUNT_ID = $discountId;
        $row->MODULE_ID = self::MODULE_ID;
        $row->save();
        return true;
    }
}