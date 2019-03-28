<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 22.03.2019
 * Time: 11:32
 */

namespace Lgcity\Promotion\Eloquent\Controllers;

use \Lgcity\Promotion\Eloquent\Models as Models;

class PropsEntity
{
    const MODULE_ID = 'catalog';
    public static function create($discountId,$params)
    {
        $params = explode(':',$params);
        switch ($params[0])
        {
            case 'CondIBProp':
                $entitY = 'ELEMENT_PROPERTY';
                $fieldEntity = 'PROPERTY_'.$params[2].'_VALUE';
                $fieldTable = $params[1].':'.$params[2];
        }
        $entity = Models\PropEntities::create([
            'DISCOUNT_ID' => $discountId,
            'MODULE_ID' => self::MODULE_ID,
            'ENTITY' => $entitY,
            'FIELD_ENTITY' => $fieldEntity,
            'FIELD_TABLE' => $fieldTable
        ]);
        $entity->save();
    }
}