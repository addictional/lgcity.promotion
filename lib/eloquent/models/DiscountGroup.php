<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 13.03.2019
 * Time: 10:12
 */

namespace Lgcity\Promotion\Eloquent\Models;

use \Illuminate\Database\Eloquent\Model;

class DiscountGroup extends Model
{
    public $timestamps = false;
    protected $primaryKey = "ID";
    protected $table = "b_sale_discount_group";
    protected $fillable = ([
        'DISCOUNT_ID',
        'ACTIVE',
        'GROUP_ID'
    ]);

}