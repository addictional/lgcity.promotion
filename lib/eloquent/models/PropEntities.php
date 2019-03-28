<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 22.03.2019
 * Time: 11:26
 */

namespace Lgcity\Promotion\Eloquent\Models;

use \Illuminate\Database\Eloquent\Model;

class PropEntities extends Model
{
    protected $table = 'b_sale_discount_entities';
    public $timestamps = false;
    protected $primaryKey = 'ID';
    protected $fillable = ([
        "DISCOUNT_ID",
        "MODULE_ID",
        "ENTITY",
        "FIELD_ENTITY",
        "FIELD_TABLE",
    ]);
}