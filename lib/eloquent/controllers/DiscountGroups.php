<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Yakovlev
 * Date: 13.03.2019
 * Time: 10:19
 */

namespace Lgcity\Promotion\Eloquent\Controllers;

use Lgcity\Promotion\Eloquent\Models as PromotionModels;

class DiscountGroups
{
    public function __construct($id)
    {
        $this->discountId = $id;
    }

    private $discountId;
    private $groups = [
        1 => [],
        2 =>[],
        3 =>[],
        4 =>[],
        5 => [],
        6 => [],
        7 => [],
        8 => [],
        9 => [],
        10 => [],
        11 => [],
        12 => []
    ];
    private function create($group ,$bool)
    {
        if($bool == 'N')
            return false;
        $row = PromotionModels\DiscountGroup::create();
        $row->DISCOUNT_ID = $this->discountId;
        $row->ACTIVE = $bool;
        $row->GROUP_ID = $group;
        $row->save();
    }
    private function update($group ,$bool)
    {
        if($bool == "Y")
           return false;
        $row = PromotionModels\DiscountGroup::Where([
            'DISCOUNT_ID' => $this->discountId,
            'GROUP_ID' => $group
            ])->first();
        $row->ACTIVE = $bool;
        $row->delete();
    }

    private function setGroups()
    {
        $result = PromotionModels\DiscountGroup::Where(['DISCOUNT_ID' => $this->discountId])->get();
        foreach ($result as $row)
        {
            if($row->ACTIVE == 'N')
                $this->groups[$row->GROUP_ID] = ['ACTIVE' => 'N','ACTION' => 'UPDATE'];
            else
                $this->groups[$row->GROUP_ID] = ['ACTIVE' => 'Y','ACTION' => 'UPDATE'];
        }
        foreach ($this->groups as &$group)
        {
            if(empty($group))
                $group = ['ACTIVE' => 'N','ACTION' => 'ADD'];
        }
    }
    public function setDiscountId($id)
    {
        $this->discountId = $id;
    }
    public function addGroups($array)
    {
        if(gettype($array) != 'array')
            return false;
        $this->setGroups();
        foreach ($array as $arr)
        {
            $this->groups[$arr]['ACTIVE'] = 'Y';
        }
        foreach ($this->groups as $index => $group){
            switch ($group['ACTION']){
                case 'ADD':
                    $this->create($index,$group['ACTIVE']);
                    break;
                case 'UPDATE':
                    $this->update($index,$group['ACTIVE']);
                    break;
            }
        }
    }
    public function disable()
    {
        PromotionModels\DiscountGroup::Where([
            'DISCOUNT_ID' => $this->discountId
        ])->update(['ACTIVE' => 'N']);
    }

    public function activate()
    {
        PromotionModels\DiscountGroup::Where([
            'DISCOUNT_ID' => $this->discountId
        ])->update(['ACTIVE' => 'Y']);
    }
    public function getById($id)
    {
        return PromotionModels\DiscountGroup::Where([ "DISCOUNT_ID" => $id ])->first();
    }
}