<?
namespace Lgcity\Promotion;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;

/**
 * 
 */
class PromotionTable extends Entity\DataManager
{
	public static function getTableName()
	{
		return 'promotion_promotion';
	}
	public static function getUfId()
	{
		return 'PROMOTION_PROMOTION';
	}
	public static function getMap(){
		return array(
			//ID
			new Entity\IntegerField('ID',array(
				'primary' => true,
				'autocomplete' => true
			)),

			// ID акции
			new Entity\IntegerField('PROMOTION_ID',array(
				'required' => true
			)),

			// картинка для баннера
			new Entity\IntegerField('PREVIEW_PICTURE',array(
				'required' => false
			)),

			// картинка для новости
			new Entity\IntegerField('DETAIL_PICTURE',array(
				'required' => false
			)),

			//описание для новости
			new Entity\TextField('DETAIL_TEXT',array(
				'required' => false
			)),

			//строка для баннера
			new Entity\TextField('PREVIEW_TEXT',array(
				'required' => false
			)),

			//стили для строки банера
			new Entity\TextField('STYLES',array(
				'required' => false
			)),

			//
			new Entity\ReferenceField(
                'DISCOUNT',
                '\Lgcity\Promotion\DiscountTable',
                array('=this.PROMOTION_ID' => 'ref.ID')
            )
		);
	}
}