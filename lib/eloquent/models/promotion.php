<?
namespace Lgcity\Promotion\Eloquent\Models;

use \Illuminate\Database\Eloquent\Model;
/**
 * 
 */
class Promotion extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected $table = 'promotion_promotion';
    public $timestamps = false;
    protected $primaryKey = 'ID';
	protected $fillable = ([
		"PROMOTION_ID",
		"PREVIEW_PICTURE",
		"DETAIL_PICTURE",
		"DETAIL_TEXT",
		"PREVIEW_TEXT",
		"STYLES",
        "ABANDONED_CARD",
        "DISCOUNT_REGISTR",
        "CLEAR_CACHE",
        "SLIDER_ID",
        "HB_ID"
	]);
	public function discount()
	{
		return $this->belongsTo('Lgcity\Promotion\Eloquent\Models\Discount','PROMOTION_ID','ID');
	}
	public function getName()
    {
        return $this->discount->NAME;
    }
}