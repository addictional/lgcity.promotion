<?
namespace Lgcity\Promotion\Eloquent\Controllers;

use \Lgcity\Promotion\Eloquent\Models as PromotionModels,
    \Carbon\Carbon;

/**
 * 
 */
class Promotions 
{
	public static function createPromotion($promotioId)
	{
	    if(self::isExist($promotioId))
	        $result = self::getById($promotioId);
	    else
		    $result = PromotionModels\Promotion::create(['PROMOTION_ID' => $promotioId]);
		return $result;
	}


	public static function getById($promotionId)
    {
        $result = PromotionModels\Promotion::Where(['PROMOTION_ID' => $promotionId])->first();
        return $result;
    }
	public static function isExist($promotionId)
    {
        $res = PromotionModels\Promotion::Where(['PROMOTION_ID' => $promotionId])->first();
        return ($res != null) ? $res->exists : false ;
    }
    public static function selectNew()
    {
        $ids = [];
        $result = PromotionModels\Discount::whereDate('ACTIVE_FROM','<=',Carbon::today())
            ->whereDate('ACTIVE_TO','>=',Carbon::today())->get();
        foreach ($result as $disc)
        {
            $ids[] = $disc->ID;
        }
        if(count($ids)>0)
        {
            $result = PromotionModels\Promotion::whereIn('PROMOTION_ID',$ids)
                ->where(['CLEAR_CACHE' => 'Y'])->get();
            return $result;
        }
    }

}