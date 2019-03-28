<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Lgcity\Promotion\Base as DBConn,
    Lgcity\Promotion\Discount as LgDiscount,
    Lgcity\Promotion\Eloquent\Controllers\HBs,
    Carbon\Carbon;

class AddPromotion extends CBitrixComponent
{
    protected $iblockId = 9;

    protected $discountProp = 286;
    public $templatePath;
    static $discount = false;
    /**
     * @param array $arParams
     */

    public function __construct(CBitrixComponent $component = null)
    {
        parent::__construct($component);
        if($this->getTemplateName()== "")
            $templatePath = '/templates/.default/';
        $this->templatePath = $this->getPath().$templatePath ;
    }

    public  static function refreshDiscount(){
        if(self::$discount && self::$discount->getId())
        {
            self::$discount->save();
        }

    }

    public static function formatDate($data)
    {
        $date = Carbon::createFromTimeString($data);
        return ConvertTimeStamp(
            mktime(
                $date->hour,
                $date->minute,
                $date->second,
                $date->month,
                $date->day,
                $date->year
            ),
            'FULL'
        );
    }

    public static function addToSlider()
    {
        if(!isset($_FILES['preview']))
            return false;
        global $USER;
        Loader::includeModule('iblock');
        $element = new CIBlockElement();
        $propers = [
            95 => $_REQUEST['HREF_TEXT_LINE'],
        ];
        $mass = [
            'MODIFIED_BY' => $USER->GetId(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID"      => 6,
            "PROPERTY_VALUES" => $propers,
            "ACTIVE" => "Y",
            "DETAIL_PICTURE" => $_FILES['preview'],
            "NAME" => $_REQUEST['NAME'],
            "ACTIVE_FROM" => self::formatDate($_REQUEST['DATE_FROM']),
            "ACTIVE_TO" => self::formatDate($_REQUEST['DATE_TO']),
            "SORT" => 1
        ];
        if($PRODUCT_ID = $element->Add($mass))
            return $PRODUCT_ID;
    }

    public static function addDiscount(){
        $request = $_REQUEST;
        $classId = 'CondIBProp:'.$request['IBLOCK'].':'.$request['PROP_ID'];
        $conditions = explode(',',$request['SEASON_DISCOUNTS']);
        new DBConn\Database();
        $discount = new LgDiscount\Main();
        $discount->setName($request['NAME']);
//        if($request['DISCOUNT_REGISTR'])
//            LgDiscount\Main::disableDiscount(18);
//        if($request['ABANDONED_CARD'])
//            LgDiscount\Main::disableDiscount(42);
        $discount->setPriority(9000000000);
        $discount->setSort(1);
        $discount->setSeparator('OR');
        $discount->setDiscountAmount($request['DISCOUNT_AMOUNT']);
        $discount->setDiscountOffset(100000);
        $discount->setDateFrom(Carbon::createFromTimeString($request['DATE_FROM']));
        $discount->setDateTo(Carbon::createFromTimeString($request['DATE_TO']));
        foreach ($conditions as $cond)
        {
            $discount->addActSaleCondChild($cond,'Contain',$classId);
        }
        $discount->createApplicationFunc();
        $discount->setDiscountType($request['DISCOUNT_TYPE']);
        $discount->setXMLId($_REQUEST['CODE_OF_DOCUMENT']);
        $discount->setUsersGroups([1,2,3,4,5,6,7,8,9,10,11,12]);
        $discount->save();
        self::$discount = $discount;
        return $discount->getId();
    }
    public static function addPromotion($discountId){
        $request = $_REQUEST;
        $files = $_FILES;
        $imgs = [];
        $promotion = Lgcity\Promotion\Eloquent\Controllers\Promotions::createPromotion($discountId);
        foreach ($files as $index => $file){
            unset($file['error']);
            $id = CFile::SaveFile($file,'lgcity.promotion');
            $imgs[] = [$index,$id];
        }
        foreach($imgs as $img)
        {
            switch ($img[0])
            {
                case 'preview':
                    $promotion->PREVIEW_PICTURE = $img[1];
                    break;
                case 'detail':
                    $promotion->DETAIL_PICTURE = $img[1];
                    break;
            }
        }
        if($request['DISCOUNT_REGISTR'])
            $promotion->DISCOUNT_REGISTR = 'Y';
        if($request['ABANDONED_CARD'])
            $promotion->ABANDONED_CARD = 'Y';
        if($request['RESET_CACHE'])
            $promotion->CLEAR_CACHE = 'Y';
        if(isset($request['detail_text']))
            $promotion->DETAIL_TEXT = self::deletePoweredBy($request['detail_text']);
        if(isset($request['STYLES_FOR_TEXTLINE']))
        {
            $styles = self::stringToArray($request['STYLES_FOR_TEXTLINE']);
            $styles = self::arrayToString($styles);
            $promotion->STYLES = $styles;
        }
        if(isset($request['TEXT_LINE']))
            $promotion->PREVIEW_TEXT =  $request['TEXT_LINE'];
        $promotion->save();

        $promotion->HB_ID = self::addToHb();
        $promotion->SLIDER_ID = self::addToSlider();
        $promotion->save();
    }

    public static function addToHb()
    {
        if(!isset($_REQUEST['TEXT_LINE']))
            return false;
        if(!isset($_REQUEST['STYLES_FOR_TEXTLINE']))
            return false;
        $request = $_REQUEST;
        $styles = self::stringToArray($request['STYLES_FOR_TEXTLINE']);
        $banner = Hbs::create();
        $banner->UF_ACTIVE_FROM = Carbon::createFromTimeString($request['DATE_FROM']);
        $banner->UF_ACTIVE_TO = Carbon::createFromTimeString($request['DATE_TO']);
        $banner->UF_SORT = 1;
        $banner->UF_ACTIVE = 1;
        $banner->UF_LINK = $request['HREF_TEXT_LINE'];
        $banner->UF_BACKGROUND_COLOR = $styles[0];
        $banner->UF_FONT_COLOR = $styles[1];
        $banner->UF_ROW_TEXT = $request['TEXT_LINE'];
        $banner->save();
        return $banner->ID;
    }
    public static function deletePoweredBy($text)
    {
        $pattern = '/<p data-f-id[A-Za-z\=\"\-\s\r\:\;\d\.\>\<\/
                    \?]*Powered by[A-Za-z\=\"\-\s\r\:\;\d\.\>\<\/\?]*<\/p>/';
        $text = preg_replace($pattern,'',$text);
        return $text;
    }

    public static function stringToArray($string)
    {
        $array = explode(',',$string);
        return $array;
    }

    public static function arrayToString ($array)
    {
        $string = '';
        foreach ($array as $item)
        {
            $string .= $item.",";
        }
        return $string;
    }

    public function onPrepareComponentParams($arParams)
    {
        if(isset($arParams['IBLOCK']) && !empty($arParams['IBLOCK']))
            $this->iblockId = $this->arParams['IBLOCK'];
        if(isset($arParams['PROPERS']) && !empty($arParams['PROPERS']))
            $this->discountProp = $arParams['PROPERS'];
        $arParams['TEMPLATE_URI'] = $this->templatePath;
        $arParams['COMPONENT_URI'] = $this->getPath();
        return $arParams;
    }

    protected function setPropers()
    {
        global $DB;
        $arr = [];
        $sql = '
            SELECT VALUE FROM b_iblock_element_property 
            WHERE IBLOCK_PROPERTY_ID = '.$this->discountProp.'
            GROUP BY VALUE
        ';
        $query = $DB->Query($sql);
        while ($row = $query->Fetch())
        {
            $values = explode(',',$row['VALUE']);
            foreach ($values as $val)
            {
                $arr[trim($val)] = trim($val);
            }
        }
        $this->reformPropers($arr);
        return $arr;
    }

     private function reformPropers(&$props){
        foreach ($props as $index => &$prop){
            if($prop == 0 )
            {
                unset($props[$index]);
                continue;
            }
            if(preg_match('/([0]{2,})/',$prop))
            {
                $prop = preg_replace('/[0]{2,}/','',$prop);
            }
        }
    }

    /**
     * @param array $arResult
     */
    public function setArResult($arResult)
    {
       if($this->startResultCache())
       {
           $this->arResult = $arResult;
           $this->arResult['URL'] = $this->templatePath;
           $this->arResult['PROPS'] = $this->setPropers();
           $this->includeComponentTemplate();
       }
    }
    public function executeComponent()
    {
        $this->setArResult();
    }

}