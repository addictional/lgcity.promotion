<?
CModule::AddAutoloadClasses(
        'lgcity.promotion', array(
    		'\Lgcity\Promotion\Base\Database' => 'classes/general/base.php',
            '\Lgcity\Promotion\Eloquent\Models\PropEntities' => 'lib/eloquent/models/PropEntities.php',
            '\Lgcity\Promotion\Eloquent\Models\HB' => 'lib/eloquent/models/HB.php',
    		'\Lgcity\Promotion\Eloquent\Models\Promotion' => 'lib/eloquent/models/promotion.php',
    		'\Lgcity\Promotion\Eloquent\Models\Discount' => 'lib/eloquent/models/discount.php',
            '\Lgcity\Promotion\Eloquent\Models\DiscountGroup' => 'lib/eloquent/models/DiscountGroup.php',
            '\Lgcity\Promotion\Eloquent\Models\DiscountModule' => 'lib/eloquent/models/DiscountModule.php',
            '\Lgcity\Promotion\Eloquent\Controllers\HBs' => 'lib/eloquent/controllers/HBs.php',
            '\Lgcity\Promotion\Eloquent\Controllers\PropsEntity' => 'lib/eloquent/controllers/PropsEntity.php',
    		'\Lgcity\Promotion\Eloquent\Controllers\Promotions' => 'lib/eloquent/controllers/promotions.php',
    		'\Lgcity\Promotion\Eloquent\Controllers\Discounts' =>'lib/eloquent/controllers/discounts.php',
            '\Lgcity\Promotion\Eloquent\Controllers\DiscountGroups' =>'lib/eloquent/controllers/DiscountGroups.php',
            '\Lgcity\Promotion\Eloquent\Controllers\DiscountModules' =>'lib/eloquent/controllers/DiscountModules.php',
    		'\Lgcity\Promotion\Discount\Main' => 'classes/general/discount.php',
        )
);