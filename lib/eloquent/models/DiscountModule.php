<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 13.03.2019
 * Time: 14:30
 */

namespace Lgcity\Promotion\Eloquent\Models;

use \Illuminate\Database\Eloquent\Model;

class DiscountModule extends Model
{

    public $timestamps = false;
    protected $primaryKey = "ID";
    protected $table = "b_sale_discount_module";
    protected $fillable = ([
        'DISCOUNT_ID',
        'MODULE_ID'
    ]);
}