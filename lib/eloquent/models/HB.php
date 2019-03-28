<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 18.03.2019
 * Time: 15:40
 */

namespace Lgcity\Promotion\Eloquent\Models;

use \Illuminate\Database\Eloquent\Model;

class HB extends Model
{
    public $timestamps = false;
    protected $table = 'promotion_row';
    protected $primaryKey = 'ID';
    protected $fillable = ([
        "UF_ROW_TEXT",
        "UF_LINK",
        "UF_BACKGROUND_COLOR",
        "UF_FONT_COLOR",
//        "UF_ROW_TYPE",
        "UF_ACTIVE_FROM",
        "UF_ACTIVE_TO",
        "UF_SORT",
        "UF_ACTIVE"
    ]);
}