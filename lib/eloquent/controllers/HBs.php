<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 18.03.2019
 * Time: 15:48
 */

namespace Lgcity\Promotion\Eloquent\Controllers;

use Lgcity\Promotion\Eloquent\Models,
    Carbon\Carbon;

class HBs
{
   public static function getActive()
   {
       $data = Models\HB::whereDate('UF_ACTIVE_FROM','<=',Carbon::today())
           ->whereDate('UF_ACTIVE_TO','>=',Carbon::today())
           ->where(['UF_ACTIVE'=> 1])->orderBy('UF_SORT','ASC')->get();
       return $data;
   }
   public static function create()
   {
       $hb = Models\HB::create();
       return $hb;
   }
}