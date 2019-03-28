<?
namespace Lgcity\Promotion;

use \Lgcity\Promotion\Eloquent\Controllers\Promotions,
	\Lgcity\Promotion\Eloquent\Controllers\Discounts;




/**
 * 
 */
abstract class MainBase
{
	public $discount;
	// id скидки
	protected $id = false;

	// картинка для баннера
	protected $previewPicture;

	// картинка для новости
	protected $detailPicture;

	// текст для баннера
	protected $previewText;

	// текст для новости
	protected $detailText;

	// стили для текста баннера
	protected $fontStyles;

	// очитить кэш компонентов при старте акции
	protected $clearCacheAtStart = false;

	//
	static $_instance;

	//
	public function getId()
	{
		return $this->id;
	}

	// возвращает id фотографии
	public function getPreviewPicture()
	{
		return $this->$previewPicture;
	}

	// возвращает id фотографии
	public function getDetailPicture()
	{
		return $this->detailPicture;
	}

	//
	public function getPreviewText()
	{
		return $this->$previewText;
	}

	//
	public function getDetailText()
	{
		return $this->detailText;
	}

	//
	public function getFontStyles()
	{
		return $this->fontStyles;
	}

	//
	abstract public function setPreviewPicture(array $picture);


	//
	abstract public function setDetailPicture(array $picture);

	//
	public function setPreviewText(string $text)
	{
		$this->$previewText = $text;
	}

	//
	public function setDetailText(string $text)
	{
		$this->detailText = $text;
	}

	//
	public function setFontStyles(string $text)
	{
		$this->fontStyles = $text;
	}

	//
	abstract protected function addPromotionTableRow();
	abstract protected function addDiscountTableRow();
	abstract protected function updatePromotionTableRow();
	abstract protected function updateDiscountTableRow();
	abstract protected function();

	public function save(){
		if($id)
		{
			$this->updatePromotionTableRow();
			$this->update
		}
	}
	//
	public static function getInstance()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}