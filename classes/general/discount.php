<?
namespace Lgcity\Promotion\Discount;

use \Carbon\Carbon,
    \Lgcity\Promotion\Eloquent\Controllers\Discounts,
    \Lgcity\Promotion\Eloquent\Controllers\DiscountGroups,
    \Lgcity\Promotion\Eloquent\Controllers\DiscountModules,
    \Lgcity\Promotion\Eloquent\Controllers\PropsEntity;



/**
 * 
 */
class Main 
{
	//id скидки
	protected $id = false;

	protected $ormObj = false;
	// имя скидки
	protected $name;

	// код купона
	protected $useCoupon = "N";

	// тип скидки (% или рубли)
	protected $discountType;

	// размер скидки
	protected $discountAmount;

	// max размер скидки
    protected $maxDiscountAmount;

	// xml_id
	protected $documentCode;

//	// включать ли скидку за брошенную корзину
//	protected $discForAbandCard = false;
//
//	// включать скидку за регистрацию
//	protected $discForRegistration = false;

	// дата с
	protected $activeFrom;

	// дата до
	protected $activeTo;

	//дата создание
	protected $timeStamp;

	protected $usersGroups = [];

	//
	protected $actions;

	//
	protected $application;

	//
	protected $active = "Y";

	//
	protected $lid;

	//
    protected $userId;

    //
    protected $separator = "AND";

    //
    protected $priority = 300;

    //
    protected $createdBy;

    //
    protected $sort = 300;

    //
    protected $lastDiscount = "Y";

	const CONDITION = [ 
		'CLASS_ID' => 'CondGroup',
		'DATA' => [
			'All' => 'AND',
		    'True' => 'True'
		],
		'CHILDREN' => []
	];

	//
	const VERSION = 3;

	//
	const UNPACK = 'function($arOrder){return ((1 == 1)); };';

	//
	const PREDICTIONS = "N";

	//
	const HAS_INDEX = "N";

	//
    const EXECUTE_MODULE = 'all';

    //
    const EXECUTE_MOD = 0;

    //
    const LAST_LEVEL_DISCOUNT = 'N';

    //
    protected $propEntities = [];

	function __construct()
	{
	    global $USER;
	    $this->userId =  $USER->GetId();
	    $this->createdBy = $this->userId;
		$this->lid = \Bitrix\Main\Context::getCurrent()->getSite();
        $this->timeStamp = Carbon::now()->format('d.m.Y h:m:s');
	}

	//
	public function getId()
	{
		return $this->id;
	}

	//
	public function getName()
	{
		return $this->name;
	}

	//
	public function getDiscountType()
	{
		return $this->discountType;
	}

	//
	public function getDiscountAmount()
	{
		return $this->discountAmount;
	}

	//
	public function	 getDocumentCode()
	{
		return $this->documentCode;
	}

	//
	public function getDiscActions()
	{
		return $this->actions;
	}

	//
	public function setName($name)
	{
		$this->name = $name;
	}

    //
    public function setDateFrom(\Carbon\Carbon $date)
    {
        $this->activeFrom = $date->format('Y-m-d h:m:s');
    }

    //
    public function setDateTo(\Carbon\Carbon $date)
    {
        $this->activeTo = $date->format('Y-m-d h:m:s');
    }

    //
    public function forbidNextDisc($string)
    {
        $this->lastDiscount = $string;
    }

    //
	public function setCoupon($string)
	{
		$this->useCoupon = $string;
	}

	//
	public function setDiscountType($type)
	{
        $this->discountType = $type;
        $this->updateDiscVars();
	}

	public function setDiscountOffset($int){
	    $this->maxDiscountAmount = $int;
	    $this->updateDiscVars();
    }
	//
	public function setDiscountAmount($amount)
	{
		$this->discountAmount = $amount;
		$this->updateDiscVars();
	}

	public function setSeparator($string)
    {
        $this->separator = $string;
        $this->updateDiscVars();
    }
	//
	public function	 setXMLId($code)
	{
		$this->documentCode = $code;
	}

	public function setPriority ($int)
    {
        $this->priority = $int;
    }

    public function  setSort($int)
    {
        $this->sort = $int;
    }

    public function  setUsersGroups($array){
	    $this->usersGroups = $array;
    }

    public function getUsersGroups()
    {
        return $this->usersGroups;
    }
	//
	public function getById($id)
	{
		$row  = Discounts::getById($id);
		if(!$row)
			return $this;
		else 
		{
			$this->id = $row["ID"];
            $this->actions = unserialize($row->ACTIONS);
			$this->setName($row['NAME']);
			$this->discountType = $this->actions['CHILDREN'][0]['DATA']['Unit'];
			$this->discountAmount = $this->actions['CHILDREN'][0]['DATA']['Value'];
			$this->maxDiscountAmount = $this->actions['CHILDREN'][0]['DATA']['Max'];
			$this->separator = $this->actions['CHILDREN'][0]['DATA']['All'];
			$this->setXMLId($row->XML_ID);
			$this->timeStamp = $row->TIMESTAMP_X;
			$this->activeFrom = $row->ACTIVE_FROM;
			$this->activeTo = $row->ACTIVE_TO;
			$this->active = $row->ACTIVE;
			$this->application = $row->APPLICATION;
			$this->priority = $row->PRIORITY;
			$this->sort = $row->SORT;
			$this->createdBy = $row->CREATED_BY;
            $this->ormObj = $row;

		}
		return $this;
	}
    private function createActionChildArr($value, $logic, $classId)
	{
		return [
			'CLASS_ID' => $classId,
			'DATA' => [
				'logic' => $logic,
				'value' => $value
			]
		];
	}
    private function  shortDescription()
    {
        return serialize([
            'TYPE' => 'Discount',
            "VALUE" => $this->discountAmount,
            "LIMIT_VALUE" => $this->maxDiscountAmount,
            'VALUE_TYPE' => $this->typeOfDiscFormated($this->actions['CHILDREN'][0]['DATA']['Unit'])
        ]);
    }
	//
	public function addActSaleCondChild( $value,$logic = 'Equal' ,$classId = "CondIBProp:10:386")
	{
		$this->actions['CHILDREN'][0]['CHILDREN'][] = $this->createActionChildArr($value, $logic, $classId);
		$this->propEntities[$classId] = $classId;
	}

	//
    private function getCondProp($proper)
    {
        return explode(':',$proper);
    }

    private function  checkForEmptyFields(){
	    if(empty($this->name))
            throw new \Exception('Name empty ',0);
        if(empty($this->discountAmount))
            throw new \Exception('Discount amount empty' , 0);
        if(empty($this->maxDiscountAmount))
            throw new \Exception('max Discount Amount empty',0);
        if (empty($this->discountType))
            throw new \Exception('Discount type empty',0);
    }

    private function updateDiscVars()
    {
        if(!$this->id && empty($this->actions))
        {
            $this->actions = self::CONDITION;
            $this->actions['CHILDREN'][0] = [
                "CLASS_ID" => "ActSaleBsktGrp",
                "DATA" => [],
                "CHILDREN" => []
            ];
        }
        $this->actions['CHILDREN'][0]['DATA'] = [
            "Type" => "Discount",
            "Value" => $this->discountAmount,
            "Unit" => $this->discountType,
            "Max" => $this->maxDiscountAmount,
            "All" => $this->separator,
            "True" => "True"
        ];
        return true;
    }
    private function typeOfDiscFormated($type)
    {
        switch($type)
        {
            case 'CurEach':
                $type = 'F';
                break;
            case 'Perc':
                $type = 'P';
                break;
        }
        return $type;
    }
    //

	//Создание функции для поля APPLICATION  в таблице b_sale_discount
    public function createApplicationFunc()
    {
        $arrOfCond = array();
	    $begin = 'function (&$arOrder){$saleact_0_0=function($row){return (';

	    // проверка на условия

	    foreach ($this->actions['CHILDREN'][0]['CHILDREN'] as $condition)
        {
            switch ($this->getCondProp($condition['CLASS_ID'])[0])
            {
                case 'CondIBProp':
//                    $iblock = $this->getCondProp($condition['CLASS_ID'])[1];
                    $element = $this->getCondProp($condition['CLASS_ID'])[2];
                    switch ($condition['DATA']['logic'])
                    {
                        case 'Equal':
                            $arrOfCond[] = '(isset($row[\'CATALOG\'][\'PROPERTY_'.$element.'_VALUE\'])'.
                            '&& in_array(\''.$condition['DATA']["value"].'\',$row[\'CATALOG\'][\'PROPERTY_'
                                .$element.'_VALUE\']))';
                            break;
                        case 'Contain':
                            $arrOfCond[] = '(isset($row[\'CATALOG\'][\'PROPERTY_'.$element.'_VALUE\'])'.
                            '&& CGlobalCondCtrl::LogicContain($row[\'CATALOG\'][\'PROPERTY_'.$element.'_VALUE\'], "'.
                                $condition['DATA']["value"].'"))';
                            break;
                        case 'NotCont':
                            $arrOfCond[] = '(isset($row[\'CATALOG\'][\'PROPERTY_'.$element.'_VALUE\'])'.
                                '&& CGlobalCondCtrl::LogicNotContain($row[\'CATALOG\'][\'PROPERTY_'.$element.'_VALUE\'], "'.
                                $condition['DATA']["value"].'"))';
                    }
            }
        }
	    $separator = '||';
	    switch($this->actions['CHILDREN'][0]['DATA']['All'])
        {
            case 'OR':
                $separator = '||';
                break;
            case 'AND':
                $separator = '&&';
                break;
        }
	    foreach ( $arrOfCond as $index => $cond)
        {
            if($index != 0 )
                $begin .= $separator;
            $begin .= $cond;
        }

        $type = $this->typeOfDiscFormated($this->actions['CHILDREN'][0]['DATA']['Unit']);
//	    switch($this->actions['CHILDREN'][0]['DATA']['Unit'])
//        {
//            case 'CurEach':
//                $type = 'F';
//                break;
//            case 'Perc':
//                $type = 'P';
//                break;
//        }

	    //конец проверки на условия

	    $begin .= ');};\Bitrix\Sale\Discount\Actions::applyToBasket($arOrder, array (
         \'VALUE\' => -'.round($this->actions['CHILDREN'][0]['DATA']['Value'],0).'.0,
         \'UNIT\' => \''.$type.'\',
         \'LIMIT_VALUE\' => '.$this->actions['CHILDREN'][0]['DATA']['Max'].',
         ), $saleact_0_0);}';
	    $this->application = $begin;
	    return true;
    }
    public function save(){
	    try
        {
            $this->checkForEmptyFields();
            $this->updateDiscVars();
            $this->createApplicationFunc();
            if(!$this->id )
            {
                $this->ormObj = Discounts::createDiscount();
                $this->ormObj->DATE_CREATE = Carbon::now()->format('Y-m-d h:m:s');
                $this->ormObj->CREATED_BY = $this->userId;

            }
            $this->ormObj->XML_ID = $this->documentCode;
            $this->ormObj->LID = $this->lid;
            $this->ormObj->NAME = $this->name;
            $this->ormObj->PRICE_FROM = '0.00';
            $this->ormObj->PRICE_TO = '0.00';
            $this->ormObj->CURRENCY = 'RUB';
            $this->ormObj->ACTIVE = $this->active;
            $this->ormObj->SORT = $this->sort;
            $this->ormObj->ACTIVE_FROM = Carbon::createFromTimeString($this->activeFrom)->
            format('Y-m-d h:m:s');
            $this->ormObj->ACTIVE_TO = Carbon::createFromTimeString($this->activeTo)->
            format('Y-m-d h:m:s');
            $this->ormObj->TIMESTAMP_X = Carbon::now()->format('Y-m-d h:m:s');
            $this->ormObj->MODIFIED_BY = $this->userId;
            $this->ormObj->PRIORITY = $this->priority;
            $this->ormObj->LAST_DISCOUNT = $this->lastDiscount;
            $this->ormobj->CONDITIONS = serialize(self::CONDITION);
            $this->ormObj->UNPACK = self::UNPACK;
            $this->ormObj->ACTIONS = serialize($this->actions);
            $this->ormObj->APPLICATION = $this->application;
            $this->ormObj->USE_COUPONS =  $this->useCoupon;
            $this->ormObj->EXECUTE_MODULE = self::EXECUTE_MODULE;
            $this->ormObj->PREDICTIONS = self::PREDICTIONS;
            $this->ormObj->HAS_INDEX = self::HAS_INDEX;
            $this->ormObj->SHORT_DESCRIPTION = $this->shortDescription();
            $this->ormObj->LAST_LEVEL_DISCOUNT = self::LAST_LEVEL_DISCOUNT;
            $this->ormObj->EXECUTE_MODE = self::EXECUTE_MOD;
            $check = $this->ormObj->save();
            if($check)
            {
                $this->id = $this->ormObj->ID;
                $usersGroups = new DiscountGroups();
                $usersGroups->setDiscountId($this->id);
                $usersGroups->addGroups($this->usersGroups);
                DiscountModules::add($this->id);
                foreach ($this->propEntities as $prop)
                {
                    PropsEntity::create($this->id,$prop);
                }
            }
        }
        catch (\Exception $e)
        {
            print($e->getMessage());
        }
    }
    protected function addGroupsAndModule()
    {

    }

    public static function disableDiscount($id)
    {
        $usersGroups = new DiscountGroups($id);
        $discount  = Discounts::getById($id);
        $discount->ACTIVE = 'N';
        $discount->save();
        $usersGroups->disable();
    }
    public static function activateDiscount($id)
    {
        $usersGroups = new DiscountGroups($id);
        $discount  = Discounts::getById($id);
        $discount->save();
        $usersGroups->activate();
    }

	public function ShowFuncAction()
    {
        return $this->application;
    }

}