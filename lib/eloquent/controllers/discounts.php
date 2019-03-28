<?
namespace Lgcity\Promotion\Eloquent\Controllers;

use Lgcity\Promotion\Eloquent\Models as PromotionModels;

/**
 * 
 */
class Discounts 
{
	public static function createDiscount()
	{
		$result = PromotionModels\Discount::create();
		return $result;
	}

	public static function discountIsset($name)
	{
		$result = PromotionModels\Discount::Where(['NAME' => $name])->get();
		if(count($result)>0)
			return true;
		return false;
	}

	public static function getById($id){
		$result = PromotionModels\Discount::Where(['ID'=>$id])->first();
		return  $result;
	}
}