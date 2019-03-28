<?
namespace Lgcity\Promotion\Eloquent\Models;

use \Illuminate\Database\Eloquent\Model;

/**
 * 
 */
class Discount extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'ID';
	protected $table = 'b_sale_discount';
	protected $fillable = ([
		'XML_ID',
		'LID',
		'NAME',
		'PRICE_FROM',
		'PRICE_TO',
		'CURRENCY',
		'DISCOUNT_VALUE',
		'DISCOUNT_TYPE',
		'ACTIVE',
		'SORT',
		'ACTIVE_FROM',
		'ACTIVE_TO',
		'TIMESTAMP_X',
		'MODIFIED_BY',
		'DATE_CREATE',
		'CREATED_BY',
		'PRIORITY',
		'LAST_DISCOUNT',
		'CONDITIONS',
		'UNPACK',
		'ACTIONS',
		'APPLICATION',
		'USE_COUPONS',
		'EXECUTE_MODULE',
		'PREDICTION_TEXT',
		'PREDICTIONS',
		'PREDICTIONS_APP',
		'HAS_INDEX',
		'PRESET_ID',
		'SHORT_DESCRIPTION',
		'LAST_LEVEL_DISCOUNT',
		'EXECUTE_MODE'
	]);
	public function promotion()
	{
		return $this->hasOne('\Lgcity\Promotion\Eloquent\Models\Promotion','ID','PROMOTION_ID');
	}
}