<?
namespace Lgcity\Promotion;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;

/**
 * 
 */
class DiscountTable extends Entity\DataManager
{
	public static function getTableName(){
		return 'b_sale_discount';
	}
	public static function getUfId(){
		return 'B_SALE_BASKET';
	}
	public static function getMap(){
		return array(
			new Entity\IntegerField('ID',array(
				'primary' => true,
				'autocomplete' => true
			)),
			new Entity\StringField('XML_ID'),
			new Entity\StringField('LID'),
			new Entity\StringField('NAME'),
			new Entity\StringField('PRICE_FROM'),
			new Entity\StringField('PRICE_TO'),
			new Entity\StringField('CURRENCY'),
			new Entity\StringField('DISCOUNT_VALUE'),
			new Entity\StringField('DISCOUNT_TYPE'),
			new Entity\StringField('ACTIVE'),
			new Entity\StringField('SORT'),
			new Entity\StringField('ACTIVE_FROM'),
			new Entity\StringField('ACTIVE_TO'),
			new Entity\StringField('TIMESTAMP_X'),
			new Entity\StringField('MODIFIED_BY'),
			new Entity\StringField('DATE_CREATE'),
			new Entity\StringField('CREATED_BY'),
			new Entity\StringField('PRIORITY'),
			new Entity\StringField('LAST_DISCOUNT'),
			new Entity\StringField('CONDITIONS'),
			new Entity\StringField('UNPACK'),
			new Entity\StringField('ACTIONS'),
			new Entity\StringField('APPLICATION'),
			new Entity\StringField('USE_COUPONS'),
			new Entity\StringField('EXECUTE_MODULE'),
			new Entity\StringField('PREDICTION_TEXT'),
			new Entity\StringField('PREDICTIONS'),
			new Entity\StringField('PREDICTIONS_APP'),
			new Entity\StringField('HAS_INDEX'),
			new Entity\StringField('PRESET_ID'),
			new Entity\StringField('SHORT_DESCRIPTION'),
			new Entity\StringField('LAST_LEVEL_DISCOUNT'),
			new Entity\StringField('EXECUTE_MODE'),
		);
	}
}